<?php

namespace CoById\Factory;

use CoById\Interface\ResponseFactoryInterface;
use CoById\Interface\ResponseInterface;
use CoById\Models\Response;

class ResponseFactory implements ResponseFactoryInterface
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
    ): ResponseInterface {
        return new Response(
            $code,
            $responseHeader,
            $responseData,
            $url,
            $errors,
            $latency
        );
    }

}
