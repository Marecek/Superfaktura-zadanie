<?php

namespace CoById\Utilities;

class SystemFacade
{
    /**
     * @return bool
     */
    public function startOutputBuffering(): bool
    {
        return ob_start();
    }

    /**
     * @param callable $handler
     * @param int|string $types
     *
     * @return callable|null
     */
    public function setErrorHandler(callable $handler, int|string $types = 'use-php-defaults'): ?callable
    {
        if ($types === 'use-php-defaults') {
            $types = E_ALL;
        }
        return set_error_handler($handler, $types);
    }

    /**
     * @param callable $handler
     *
     * @return callable|null
     */
    public function setExceptionHandler(callable $handler): ?callable
    {
        return set_exception_handler($handler);
    }

    /**
     * @return void
     */
    public function restoreExceptionHandler(): void
    {
        restore_exception_handler();
    }

    /**
     * @return void
     */
    public function restoreErrorHandler(): void
    {
        restore_error_handler();
    }

    /**
     * @param callable $function
     *
     * @return void
     */
    public function registerShutdownFunction(callable $function): void
    {
        register_shutdown_function($function);
    }

    /**
     * @return string|false
     */
    public function cleanOutputBuffer(): bool|string
    {
        return ob_get_clean();
    }

    /**
     * @return int
     */
    public function getOutputBufferLevel(): int
    {
        return ob_get_level();
    }

    /**
     * @return bool
     */
    public function endOutputBuffering(): bool
    {
        return ob_end_clean();
    }

    /**
     * @return void
     */
    public function flushOutputBuffer(): void
    {
        flush();
    }

    /**
     * @return int
     */
    public function getErrorReportingLevel(): int
    {
        return error_reporting();
    }

    /**
     * @return array|null
     */
    public function getLastError(): ?array
    {
        return error_get_last();
    }

    /**
     * @param int $httpCode
     *
     * @return int
     */
    public function setHttpResponseCode(int $httpCode): int
    {
        if (!headers_sent()) {
            header_remove('location');
        }

        return http_response_code($httpCode);
    }


    /**
     * @param int $exitStatus
     *
     * @return void
     */
    public function stopExecution(int $exitStatus): void
    {
        exit($exitStatus);
    }
}
