<?php

namespace CoById\Interface;

interface ResponseFactoryInterface
{
    /**
     * @param int $code
     * @param string $responseHeader
     * @param string $responseData
     * @param string $url
     * @param array<string>|null $errors
     * @param int|float|null $latency
     *
     * @return ResponseInterface
     */
    public function create(
        int $code,
        string $responseHeader,
        string $responseData,
        string $url,
        ?array $errors,
        int|float|null $latency,
    ): ResponseInterface;
}
