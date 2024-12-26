<?php
//
//require __DIR__ . '/vendor/autoload.php';
//
//use Src\Commerce\Products\Domain\Models\Product;
//use Src\Commerce\Products\Domain\Services\CurrencyConverterInterface;
//use Src\Commerce\Products\Domain\Services\IdGeneratorInterface;
//use Src\Commerce\Products\Infrastructure\Container;
//use Src\Commerce\Products\Infrastructure\Services\CurrencyConverter;
//use Src\Commerce\Products\Infrastructure\Services\IdGenerator;
//use Src\Commerce\Products\Domain\Repositories\ProductRepositoryInterface;
//
//$container = new Container();
//
//$container->bind(CurrencyConverterInterface::class, CurrencyConverter::class);
//$container->bind(IdGeneratorInterface::class, IdGenerator::class);
//$pdo = new PDO('mysql:host=localhost;dbname=mi_base_de_datos', 'usuario', 'password');
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//$container->bind(
//    ProductRepositoryInterface::class,
//    function () use ($pdo) {
//        return new PdoProductRepository($pdo);
//    }
//);