<?php

namespace CoById\Interface;

use CoById\Exception\ExcError;
use CoById\Models\Request;
use CoById\Models\Response;

interface RequestInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $providerUrl
     *
     * @return void
     */
    public function setUrl(string $providerUrl): void;

    /**
     * @return string
     */
    public function getResponseUrl(): string;


    /**
     * @param string $responseUrl
     *
     * @return void
     */
    public function setResponseUrl(string $responseUrl): void;

    /**
     * @return int|string|null
     */
    public function getAppendId(): int|string|null;

    /**
     * @param int|string $appendId
     *
     * @return void
     */
    public function setAppendId(int|string $appendId): void;


    /**
     * @return void
     */
    public function unsetAppendId(): void;


    /**
     * @return string
     */
    public function getResponseFormat(): string;

    /**
     * @param string $responseFormat
     *
     * @return void
     */
    public function setResponseFormat(string $responseFormat = 'json'): void;

    /**
     * @return string
     */
    public function getUserAgent(): string;

    /**
     * @param string $userAgent
     *
     * @return void
     */
    public function setUserAgent(string $userAgent): void;

    /**
     * @return string
     */
    public function getAllowedOrigin(): string;

    /**
     * @param string $allowedOrigin
     *
     * @return void
     */
    public function setAllowedOrigin(string $allowedOrigin): void;

    /**
     * @return int
     */
    public function getTimeout(): int;

    /**
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function setAuthCredentials(string $username, string $password): void;

    /**
     * @return void
     */
    public function enableSSL(): void;

    /**
     * @return void
     */
    public function disableSSL(): void;

    /**
     * @param int $timeout
     *
     * @return void
     */
    public function setTimeout(int $timeout = 15): void;

    /**
     * @return int
     */
    public function getConnectionTimeOut(): int;

    /**
     * @param int $connectionTimeout
     *
     * @return void
     */
    public function setConnectionTimeOut(int $connectionTimeout = 10): void;

    /**
     * @return array
     */
    public function getAllowedRequestMethods(): array;

    /**
     * @return array
     */
    public function getAllowedResponseFormat(): array;


    /**
     * @return array
     */
    public function getRequestOptionKeys(): array;

    /**
     * @return string
     */
    public function getRequestMethod(): string;

    /**
     * @param string $method
     *
     * @return void
     */
    public function setRequestMethod(string $method): void;

    /**
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data = []): void;

    /**
     * @return string
     */
    public function getResponseData(): string;

    /**
     * @param string $responseData
     *
     * @return void
     */
    public function setResponseData(string $responseData): void;

    /**
     * @return string
     */
    public function getResponseHeader(): string;

    /**
     * @param string $responseHeader
     *
     * @return void
     */
    public function setResponseHeader(string $responseHeader): void;

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @param int $code
     *
     * @return void
     */
    public function setCode(int $code): void;

    /**
     * @return string
     */
    public function getLatency(): string;

    /**
     * @param int $latency
     *
     * @return string
     */
    public function setLatency(int $latency): string;

    /**
     * @return array|null
     */
    public function getErrors(): ?array;

    /**
     * @param array|string|null $errors
     *
     * @return void
     */
    public function setErrors(array|string|null $errors): void;

    /**
     * @param string $responseData
     *
     * @return bool
     */
    public function verifyResponseData(string $responseData = ''): bool;

    /**
     * @return Response
     */
    public function getRequestResponse(): Response;

    /**
     * @return bool
     */
    public function hasResponse(): bool;

    /**
     * @return void
     * @throws ExcError
     */
    public function send(): void;

}
