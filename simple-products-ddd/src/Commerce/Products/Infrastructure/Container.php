<?php

namespace Src\Commerce\Products\Infrastructure;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;
use Closure;

class Container
{
    protected $bindings = [];
    protected $instances = [];

    /**
     * Ahora el segundo parámetro se acepta como 'mixed' en lugar de 'string'
     */
    public function bind(string $abstract, mixed $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function make(string $abstract)
    {
        // Si ya hay una instancia cacheada (singleton), la retornamos
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Tomamos lo que se haya registrado, o si no hay nada, usamos $abstract
        $concrete = $this->bindings[$abstract] ?? $abstract;

        // 1. Si es una closure, la ejecutamos (p.e. inyectar PDO o crear la instancia)
        if ($concrete instanceof Closure) {
            $object = $concrete($this);
        } else {
            // 2. De lo contrario, asumimos que es un string con el nombre de la clase
            $object = $this->build($concrete);
        }

        // Podrías guardar la instancia en $this->instances[$abstract] si quieres un "singleton"
        // $this->instances[$abstract] = $object;

        return $object;
    }

    public function build(string $concrete)
    {
        try {
            $reflector = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new Exception("The class {$concrete} does not exist");
        }

        if (!$reflector->isInstantiable()) {
            throw new Exception("The class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        // Si no tiene constructor, se hace new $concrete
        if (is_null($constructor)) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                // Inyecta la dependencia recursivamente
                $dependencyClass = $type->getName();
                $dependencies[] = $this->make($dependencyClass);
            } elseif ($type instanceof ReflectionUnionType) {
                throw new \Exception("Cannot resolve union types in {$concrete}.");
            } else {
                // Si hay valor por defecto, se usa
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("Cannot resolve the dependencies for \${$parameter->getName()} in {$concrete}.");
                }
            }
        }

        // Finalmente, se crea la instancia con los dependencies resueltos
        return $reflector->newInstanceArgs($dependencies);
    }
}