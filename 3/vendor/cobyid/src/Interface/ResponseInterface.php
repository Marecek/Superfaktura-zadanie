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
     * @param string $responseHader
     *
     * @return void
     */
    public function setReponseHeader(string $responseHader): void;


    /**
     * @return string
     */
    public function getResponseData(): string;

    /**
     * @param string $responseData
     *
     * @return void
     */
    public function setReponseData(string $responseData): void;

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
     * @return array|null
     */
    public function getErrors(): ?array;


    /**
     * @param array|null $errors
     *
     * @return void
     */
    public function setErrors(?array $errors): void;

    /**
     * @return int
     */
    public function getLatency(): int;


    /**
     * @param int $latency
     *
     * @return void
     */
    public function setLatency(int $latency): void;

    /**
     * @return array
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
