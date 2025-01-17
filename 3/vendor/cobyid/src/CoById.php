<?php

namespace CoById;

use CoById\Exception\ExcError;
use CoById\Factory\RequestFactory;
use CoById\Handler\BaseBaseHandler;
use CoById\Handler\Handler;
use CoById\Interface\BaseHandlerInterface;
use CoById\Interface\CoByIdInterface;
use CoById\Interface\ExcInspectorFactoryInterface;
use CoById\Interface\ExcInspectorInterface;
use CoById\Interface\RequestFactoryInterface;
use CoById\Interface\RequestInterface;
use CoById\Models\Response;
use CoById\Request\Request;
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
        $userAgent = 'Keram';
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
    private bool
        $output = true;


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
     * @param string|null $coId
     *
     * @return bool
     */
    public function isCoIdValid(?string $coId): bool
    {
        return null !== $coId && $this->validateCzCoId($coId);
    }

    /**
     * @param Request $request
     *
     * @return Request
     */
    public function getRequestMethod(Request $request): Request
    {
        return $request->getRequestMethod();
    }

    /**
     * @param Request $request
     * @param string|null $method
     *
     * @return CoById|Throwable
     */
    public function setRequestMethod(
        Request $request,
        ?string $method
    ): CoById|Throwable {
        if ($method && in_array($method, $request->getAllowedRequestMethods())) {
            $request->setRequestMethod($method);

            return $this;
        }
        $msg = sprintf(
            " %s is invalid method, please provide valid Request method",
            (string)$method
        );
        $this->throwInvalidArgumentException($msg);
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
     * @return CoById|Throwable
     */
    public function setRequestResponseFormat(
        Request $request,
        ?string $responseFormat,
    ): CoById|Throwable {
        $allowedResponseFormats = $request->getAllowedResponseFormat();

        if ($responseFormat && in_array($responseFormat, $allowedResponseFormats)) {
            $request->setResponseFormat($responseFormat);

            return $this;
        }
        $msg = sprintf(
            " %s is invalid response format, allowed formats are " . implode(', ', $allowedResponseFormats),
            (string)$responseFormat
        );
        $this->throwInvalidArgumentException($msg);
    }

    /**
     * @param int|string $coId
     * @param string $responseFormat
     *
     * @return string
     */
    public function getCompanyById(
        int|string $coId
    ): Response {
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
     * @param string|array $data
     *
     * @return Response
     * @throws ExcError
     */
    public function postCompanyById(
        int|string $coId,
        string|array $data
    ): Response {
        if (! $this->isCoIdValid($coId)) {
            $this->throwInvalidCoIdException($coId);
        }

        $request = $this->getRequest();
        $request->setRequestMethod('POST');
        $data = is_array($data) ? json_encode($data) : $data;
        $request->setResponseData($data);
        $request->setAppendId($coId);
        $request->setResponseFormat();
        $request->send();

        return $request->getRequestResponse();
    }

    /**
     * @param $send
     *
     * @return bool
     */
    public function writeToOutput($send = null): bool
    {
        if (func_num_args() == 0) {
            return $this->output;
        }

        return $this->output = (bool)$send;
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
     * @param null $httpCode
     *
     * @return int|false
     */
    public function httpCode($httpCode = null): int|false
    {
        if (func_num_args() == 0) {
            return $this->httpCode;
        }

        if (! $httpCode) {
            return $this->httpCode = false;
        }

        if ($httpCode === true) {
            $httpCode = 500;
        }

        return $this->httpCode = $httpCode;
    }

    /**
     * @param null $exitCode
     *
     * @return int|false
     */
    public function exitCode($exitCode = null): int|false
    {
        if (func_num_args() == 0) {
            return $this->exitCode;
        }

        return $this->exitCode = (int)$exitCode;
    }


    /**
     * @return RequestInterface|Throwable
     */
    private function getRequest(): RequestInterface|Throwable
    {
        $providerUrl = $this->getProviderUrl();

        return $this->requestFactory->create($providerUrl);
    }

    /**
     * @param string $providerUrl
     *
     * @return Throwable
     */
    private function throwInvalidUrlException(string $providerUrl): Throwable
    {
        $msg = sprintf(
            " %s is invalid provider Url, please provide correct provider url",
            $providerUrl
        );
        $this->throwInvalidArgumentException($msg);
    }

    /**
     * @param int|string $coId
     *
     * @return Throwable
     */
    private function throwInvalidCoIdException(int|string $coId): Throwable
    {
        $msg = sprintf(
            " %s is invalid Czech company ID ( ICO ) , please provide correct format of company ID",
            (string)$coId
        );
        $this->throwInvalidArgumentException($msg);
    }

    /**
     * @param string $msg
     *
     * @return Throwable
     */
    private function throwInvalidArgumentException(string $msg): Throwable|string
    {

        $exception =  new InvalidArgumentException($msg);

        if (! $this->isAjaxRequest()) {
            throw $exception;
        }
        echo json_encode(array(
            'error' => array(
                'msg' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ),
        ));
    }
}
