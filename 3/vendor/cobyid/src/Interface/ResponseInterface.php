<?php

namespace CoById\Interface;

interface ResponseInterface
{
    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @param int $code
     *
     * @return bool
     */
    public function isSuccess(int $code): bool;
    /**
     * @param int $code
     *
     * @return void
     */
    public function setCode(int $code): void;

    /**
     * @return bool
     */
    public function getError(): bool;


    /**
     * @param bool $error
     *
     * @return void
     */
    public function setError(bool $error): void;

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
    public function getUrl(): string;

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void;


    /**
     * @return array<string>|null
     */
    public function getErrors(): ?array;


    /**
     * @param array<string>|null $errors
     *
     * @return void
     */
    public function setErrors(?array $errors): void;

    /**
     * @return int|float
     */
    public function getLatency(): int|float;

    /**
     * @param int $latency
     *
     * @return void
     */
    public function setLatency(int $latency): void;

    /**
     * @return array<string>
     */
    public function toArray(): array;

    /**
     * @return bool|string
     */
    public function toJson(): bool|string;

    /**
     * @return mixed
     */
    public function toObject(): mixed;

    /**
     * @return bool|string
     */
    public function toXml(): bool|string;
}
