<?php

namespace CoById\Interface;

interface ResponseFactoryInterface
{
    /**
     * @param int $code
     * @param string $responseHeader
     * @param string $responseData
     * @param string $url
     * @param array|null $errors
     * @param int|null $latency
     *
     * @return ResponseInterface
     */
    public function create(
        int $code,
        string $responseHeader,
        string $responseData,
        string $url,
        ?array $errors,
        ?int $latency,
    ): ResponseInterface;
}
