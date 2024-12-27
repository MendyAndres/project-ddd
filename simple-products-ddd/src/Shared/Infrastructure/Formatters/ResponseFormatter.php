<?php
declare(strict_types=1);

namespace Src\Shared\Infrastructure\Formatters;

final class ResponseFormatter
{
    /**
     * Formats a successful response.
     *
     * @param mixed $data The data to include in the response.
     * @param string $message The success message (default is 'Success').
     * @return array The formatted success response.
     */
    public static function success(mixed $data, string $message = 'Success'): array
    {
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * Formats an error response.
     *
     * @param string $message The error message.
     * @param int $code The error code (default is 500).
     * @return array The formatted error response.
     */
    public static function error(string $message, int $code = 500): array
    {
        return [
            'status' => 'error',
            'message' => $message,
            'code' => $code,
        ];
    }
}
