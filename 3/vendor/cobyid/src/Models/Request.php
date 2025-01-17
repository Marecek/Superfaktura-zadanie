<?php

namespace CoById\Models;

use CoById\Exception\ExcError;
use CoById\Factory\RequestFactory;
use CoById\Factory\ResponseFactory;
use CoById\Interface\RequestFactoryInterface;
use CoById\Interface\RequestInterface;
use CoById\Interface\ResponseFactoryInterface;
use CoById\Utilities\Utilities;

class Request implements RequestInterface
{
    use Utilities;

    public const REQUEST_ALLOWED_METHODS = [
        'GET',
        'POST',
        'PUT',
        'DELETE',
    ],
        REQUEST_RESPONSE_ALLOWED_FORMATS = [
        'json',
        'xml'
    ],
        REQUEST_OPTIONS = [
        'auth',
        'method',
        'data',
        'url',
        'connectionTimeout',
        'timeout',
        'ssl',
        'userAgent',
    ];

    private int
        $connectionTimeout = 10;
    private int
        $timeout = 15;
    private int
        $code;
    private int
        $latency = 0;

    private int|string|null
        $appendId = null;

    private bool
        $cookiesEnabled = false;
    private bool
        $ssl = false;
    private bool
        $json = false;
    private bool
        $cached;

    private string
        $url;
    private string
        $responseUrl;
    private string
        $requestMethod = 'GET';
    private string
        $parameters;
    private string
        $responseFormat;
    private string
        $root;
    private string
        $auth;
    private string
        $responseData;
    private string
        $responseHeader;
    private string
        $allowedOrigin = '*';
    private string
        $userAgent = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0';

    private ?RequestFactoryInterface $requestFactory;
    protected ?ResponseFactoryInterface $responseFactory;

    public ?array
        $data = null;
    public ?array
        $errors = [];

    /**
     * @throws Exception
     */
    public function __construct(
        string $url,
        ?RequestFactoryInterface $requestFactory = null,
        ?ResponseFactoryInterface $responseFactory = null
    ) {
        $this->url             = $url;
        $this->requestFactory  = $requestFactory ?: new RequestFactory();
        $this->responseFactory = $responseFactory ?: new ResponseFactory();
        $this->root            = $this->getRootDir();
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     *
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    /**
     *
     * @param string $responseUrl
     */
    public function setResponseUrl(string $responseUrl): void
    {
        $this->responseUrl = $responseUrl;
    }



    /**
     * @return int|string|null
     */
    public function getAppendId(): int|string|null
    {
        return $this->appendId;
    }

    public function setAppendId(int|string $appendId): void
    {
        $this->appendId = $appendId;
    }

    /**
     * @return void
     */
    public function unsetAppendId(): void
    {
        $this->appendId = null;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     *
     * @param string $userAgent
     */
    public function setUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }


    /**
     * @return string
     */
    public function getAllowedOrigin(): string
    {
        return $this->allowedOrigin;
    }

    public function setAllowedOrigin(string $allowedOrigin): void
    {
        $this->allowedOrigin = $allowedOrigin;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }


    /**
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function setAuthCredentials(string $username, string $password): void
    {
        $this->auth = $username . ':' . $password;
    }

    /**
     * @return void
     */
    public function enableSSL(): void
    {
        $this->ssl = true;
    }

    /**
     * @return void
     */
    public function disableSSL(): void
    {
        $this->ssl = false;
    }

    /**
     * @param int $timeout
     *
     * @return void
     */
    public function setTimeout(int $timeout = 15): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getConnectionTimeOut(): int
    {
        return $this->connectionTimeout;
    }

    /**
     * @param int $connectionTimeout
     *
     * @return void
     */
    public function setConnectionTimeOut(int $connectionTimeout = 10): void
    {
        $this->connectionTimeout = $connectionTimeout;
    }


    /**
     * @return string[]
     */
    public function getAllowedRequestMethods(): array
    {
        return self::REQUEST_ALLOWED_METHODS;
    }

    /**
     * @return string[]
     */
    public function getAllowedResponseFormat(): array
    {
        return self::REQUEST_RESPONSE_ALLOWED_FORMATS;
    }

    /**
     * @return string[]
     */
    public function getRequestOptionKeys(): array
    {
        return self::REQUEST_OPTIONS;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }


    /**
     * @param string $method
     *
     * @return void
     */
    public function setRequestMethod(string $method): void
    {
        $this->requestMethod = $method;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data = []): void
    {
        $this->data = $data;
    }


    /**
     * @return bool
     */
    public function hasResponse(): bool
    {
        return $this->hasCode();
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
     * @return bool
     */
    public function hasCode(): bool
    {
        return isset($this->code);
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
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
     * @return string
     */
    public function getLatency(): string
    {
        return $this->latency;
    }

    /**
     * @param int $latency
     *
     * @return string
     */
    public function setLatency(int $latency): string
    {
        return $this->latency = $latency;
    }

    /**
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param array|string|null $errors
     *
     * @return void
     */
    public function setErrors(array|string|null $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @param string $responseData
     *
     * @return bool
     */
    public function verifyResponseData(string $responseData = ''): bool
    {
        if ($this->code == 200 && ! empty($this->responseData)) {
            if (str_contains($this->responseData, $responseData)) {
                return true;
            }
        }

        return false;
    }


    /**
     * @return void
     * @throws ExcError
     */
    public function send(): void
    {
        try {
            $curl = curl_init();

            $this->setCUrlRequestOptions($curl);

            $response     = curl_exec($curl);
            $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $errors = curl_error($curl);

            $headSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $time     = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
            $responseUrl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
            curl_close($curl);
            $responseData = substr($response, $headSize);

            $responseCode = empty((array) json_decode($responseData)) ? 404 : $responseCode;

            if (200 !== $responseCode) {
                $errors = (array) json_decode($errors);

                if (404 == $responseCode) {
                    $errors[] =    [
                        'code' => $responseCode,
                        'msg' => 'Target url returned with Not found response',
                    ];
                }

                $this->setErrors($errors);
            }
            $this->setCode($responseCode);
            $this->setResponseUrl($responseUrl);
            $this->setResponseHeader(substr($response, 0, $headSize));
            $this->setResponseData($responseData);
            $this->setLatency(round($time * 1000));
        } catch (ExcError $e) {
            if (! $this->isAjaxRequest()) {
                throw $e;
            }
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),
            ));
        }
    }


    /**
     * @return Response
     */
    public function getRequestResponse(): Response
    {

        $response = $this->responseFactory->create(
            $this->getCode(),
            $this->getResponseHeader(),
            $this->getResponseData(),
            $this->getResponseUrl(),
            $this->getErrors(),
            $this->getLatency()
        );

        return $response;
    }

    /**
     * @return string
     */
    public function getResponseFormat(): string
    {
        return $this->responseFormat;
    }

    /**
     * @param string $responseFormat
     *
     * @return void
     */
    public function setResponseFormat(string $responseFormat = 'json'): void
    {
        $this->responseFormat = $responseFormat;
    }

    /**
     * @param $curl
     *
     * @return void
     */
    private function setCUrlRequestOptions($curl): void
    {
        if (isset($this->auth)) {
            curl_setopt($curl, CURLOPT_USERPWD, $this->auth);
        }

        if (isset($this->requestMethod)) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->requestMethod);
            if ($this->requestMethod == 'POST' && isset($this->responseData)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $this->responseData);
            }
        }
        $url = $this->url;

        if (null !== $this->appendId) {
            $url .= DIRECTORY_SEPARATOR . $this->appendId;
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->ssl);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_ENCODING, "UTF-8");
    }

}
