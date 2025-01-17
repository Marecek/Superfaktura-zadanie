<?php

namespace CoById\Models;

use CoById\Interface\ResponseInterface;
use SimpleXMLElement;

class Response implements ResponseInterface
{
    public const RESPONSE_SUCCESS_CODES = [
        200,
        201,
        202,
        203,
        204
    ];
    private bool
        $error;

    private int
        $code;
    private int|float
        $latency = 0;

    private string
        $url;
    private string
        $responseData;
    private string
        $responseHeader;
    /**
     * @var array<string>|null
     */
    public ?array
        $errors = null;

    /**
     * @param int $code
     * @param string $responseHeader
     * @param string $responseData
     * @param string $url
     * @param array<string>|null $errors
     * @param int|float|null $latency
     */
    public function __construct(
        int $code,
        string $responseHeader,
        string $responseData,
        string $url,
        ?array $errors,
        int|float|null $latency,
    ) {
        $this->code           = $code;
        $this->responseHeader = $responseHeader;
        $this->responseData   = $responseData;
        $this->url            = $url;
        $this->errors         = $errors ?? $this->errors;
        $this->latency        = $latency ?? $this->latency;

        $this->error = $this->isSuccess($code);
    }


    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param ?int $code
     *
     * @return bool
     */
    public function isSuccess(?int $code = null): bool
    {
        $code = $code ?? $this->getCode();

        return in_array($code, self::RESPONSE_SUCCESS_CODES);
    }

    /**
     * @param int $code
     *
     * @return void
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return bool
     */
    public function getError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     *
     * @return void
     */
    public function setError(bool $error): void
    {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getResponseHeader(): string
    {
        return $this->responseHeader;
    }

    /**
     * @param string $responseHeader
     *
     * @return void
     */
    public function setResponseHeader(string $responseHeader): void
    {
        $this->responseHeader = $responseHeader;
    }

    /**
     * @return string
     */
    public function getResponseData(): string
    {
        return $this->responseData;
    }

    /**
     * @param string $responseData
     *
     * @return void
     */
    public function setResponseData(string $responseData): void
    {
        $this->responseData = $responseData;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return array<string>|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param array<string>|null $errors
     *
     * @return void
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return int|float
     */
    public function getLatency(): int|float
    {
        return $this->latency;
    }

    /**
     * @param int $latency
     *
     * @return void
     */
    public function setLatency(int $latency): void
    {
        $this->latency = $latency;
    }


    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return $this->prepareResponseData();
    }

    /**
     * @return bool|string
     */
    public function toJson(): bool|string
    {
        return json_encode($this->toArray());
    }

    /**
     * @return string|false
     */
    public function toObject(): string|false
    {
        return $this->toJson() ? json_decode((string)$this->toJson()) : false;
    }


    /**
     * @return bool|string
     */
    public function toXml(): bool|string
    {
        $data = $this->toArray();


        $xml = new SimpleXMLElement('<root/>');

        array_walk_recursive($data, array($xml, 'addChild'));

        return $xml->asXML();
    }


    /**
     * @return array<string, mixed>
     */
    private function prepareResponseData(): array
    {
        $response = [
            'code'    => $this->getCode(),
            'error'   => $this->getError(),
            'url'     => $this->getUrl(),
            'latency' => $this->getLatency(),
            'header'  => $this->getResponseHeader(),
            'data'    => [],
            'errors'  => [],
        ];

        if ($this->isSuccess()) {
            $response['data'] = json_decode($this->getResponseData(), true);
        } else {
            if ($this->getErrors()) {
                $response['errors'] = (array)json_decode((string) json_encode($this->getErrors()), true);
            }
        }

        return $response;
    }


}
