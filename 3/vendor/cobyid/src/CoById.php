<?php

namespace CoById;

use CoById\Exception\ExcError;
use CoById\Factory\RequestFactory;
use CoById\Interface\CoByIdInterface;
use CoById\Interface\RequestFactoryInterface;
use CoById\Interface\RequestInterface;
use CoById\Interface\ResponseInterface;
use CoById\Models\Response;
use CoById\Models\Request;
use CoById\Utilities\SystemFacade;
use CoById\Utilities\Utilities;
use Throwable;
use InvalidArgumentException;

final class CoById implements CoByIdInterface
{
    use Utilities;

    private string
        $providerUrl;
    private string
        $userAgent = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0';
    private ?int
        $coId = null;
    private SystemFacade
        $systemFacade;

    private RequestFactoryInterface
        $requestFactory;

    private bool
        $result = true;
    private bool
        $quit = true;



    /**
     * @param SystemFacade|null $systemFacade
     */
    public function __construct(
        string $providerUrl = '',
        SystemFacade $systemFacade = null
    ) {
        if (! $this->isUrlValid($providerUrl)) {
            $this->throwInvalidUrlException($providerUrl);
        }
        $this->setProviderUrl($providerUrl);
        $this->systemFacade   = $systemFacade ?: new SystemFacade();
        $this->requestFactory = new RequestFactory();
    }


    /**
     * @return string
     */
    public function getProviderUrl(): string
    {
        return $this->providerUrl;
    }

    /**
     * @param string $providerUrl
     *
     * @return void
     */
    public function setProviderUrl(string $providerUrl): void
    {
        $this->providerUrl = $providerUrl;
    }

    /**
     * @param string $providerUrl
     *
     * @return bool
     */
    public function isUrlValid(string $providerUrl): bool
    {
        if (filter_var($providerUrl, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string|int|null $coId
     *
     * @return bool
     */
    public function isCoIdValid(string|int|null $coId): bool
    {
        return null !== $coId && $this->validateCzCoId($coId);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function getRequestMethod(Request $request): string
    {
        return $request->getRequestMethod();
    }

    /**
     * @param Request $request
     * @param string|null $method
     *
     * @return CoById|string
     */
    public function setRequestMethod(
        Request $request,
        ?string $method
    ): CoById|string {
        if ($method && in_array($method, $request->getAllowedRequestMethods())) {
            $request->setRequestMethod($method);

            return $this;
        }
        $msg = sprintf(
            " %s is invalid method, please provide valid Request method",
            $method
        );
        return $this->throwInvalidArgumentException($msg);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function getRequestResponseFormat(Request $request): string
    {
        return $request->getResponseFormat();
    }


    /**
     * @param Request $request
     * @param string|null $responseFormat
     *
     * @return string|CoById
     */
    public function setRequestResponseFormat(
        Request $request,
        ?string $responseFormat,
    ): string|CoById {
        $allowedResponseFormats = $request->getAllowedResponseFormat();

        if ($responseFormat && in_array($responseFormat, $allowedResponseFormats)) {
            $request->setResponseFormat($responseFormat);

            return $this;
        }
        $msg = sprintf(
            " %s is invalid response format, allowed formats are " . implode(', ', $allowedResponseFormats),
            (string)$responseFormat
        );
        return $this->throwInvalidArgumentException($msg);
    }

    /**
     * @param int|string|null $coId
     *
     * @return ResponseInterface|Response
     * @throws ExcError
     */
    public function getCompanyById(
        int|string|null $coId
    ): ResponseInterface|Response {
        if (! $this->isCoIdValid($coId)) {
            $this->throwInvalidCoIdException($coId);
        }

        $request = $this->getRequest();
        $request->setRequestMethod('GET');
        $request->setAppendId($coId);
        $request->setResponseFormat();
        $request->send();

        return $request->getRequestResponse();
    }

    /**
     * @param int|string $coId
     * @param string|array<string> $data
     *
     * @return ResponseInterface|Response
     * @throws ExcError
     */
    public function postCompanyById(
        int|string $coId,
        string|array $data
    ): ResponseInterface|Response {
        if (! $this->isCoIdValid($coId)) {
            $this->throwInvalidCoIdException($coId);
        }

        $request = $this->getRequest();
        $request->setRequestMethod('POST');
        $data = is_array($data) ? json_encode($data) : $data;
        if ($data) {
            $request->setResponseData($data);
        }

        $request->setAppendId($coId);
        $request->setResponseFormat();
        $request->send();

        return $request->getRequestResponse();
    }


    /**
     * @param RequestFactoryInterface $factory
     *
     * @return void
     */
    public function setRequestFactory(RequestFactoryInterface $factory): void
    {
        $this->requestFactory = $factory;
    }

    /**
     * @param $exit
     *
     * @return bool
     */
    public function quit($exit = null): bool
    {
        if (func_num_args() == 0) {
            return $this->quit;
        }

        return $this->quit = (bool)$exit;
    }


    /**
     * @return RequestInterface
     */
    private function getRequest(): RequestInterface
    {
        $providerUrl = $this->getProviderUrl();

        return $this->requestFactory->create($providerUrl);
    }

    /**
     * @param string $providerUrl
     *
     * @return string
     */
    private function throwInvalidUrlException(string $providerUrl): string
    {
        $msg = sprintf(
            " %s is invalid provider Url, please provide correct provider url",
            $providerUrl
        );
        return $this->throwInvalidArgumentException($msg);
    }

    /**
     * @param int|string|null $coId
     *
     * @return string
     */
    private function throwInvalidCoIdException(int|string|null $coId): string
    {
        $msg = sprintf(
            " %s is invalid Czech company ID ( ICO ) , please provide correct format of company ID",
            $coId
        );
        return $this->throwInvalidArgumentException($msg);
    }

    /**
     * @param string $msg
     *
     * @return string|false
     */
    private function throwInvalidArgumentException(string $msg): string|false
    {

        $exception =  new InvalidArgumentException($msg);

        if (! $this->isAjaxRequest()) {
            throw $exception;
        }
        return json_encode([
            'error' => [
                'msg' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ],
        ]);
    }

    /**
     * @param string $userAgent
     *
     * @return CoById
     */
    public function setUserAgent(string $userAgent): CoById
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCoId(): ?int
    {
        return $this->coId;
    }

    /**
     * @param int|null $coId
     */
    public function setCoId(?int $coId): void
    {
        $this->coId = $coId;
    }

    /**
     * @return SystemFacade
     */
    public function getSystemFacade(): SystemFacade
    {
        return $this->systemFacade;
    }

    /**
     * @param SystemFacade $systemFacade
     */
    public function setSystemFacade(SystemFacade $systemFacade): void
    {
        $this->systemFacade = $systemFacade;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @return bool
     */
    public function isResult(): bool
    {
        return $this->result;
    }

    /**
     * @param bool $result
     */
    public function setResult(bool $result): void
    {
        $this->result = $result;
    }

}
