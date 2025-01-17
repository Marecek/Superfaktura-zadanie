<?php

namespace CoById\Interface;

use CoById\CoById;
use CoById\Exception\ExcError;
use CoById\Models\Response;
use Throwable;

interface CoByIdInterface
{
    /**
     * @return string
     */
    public function getProviderUrl(): string;

    /**
     * @param string $url
     *
     * @return void
     */
    public function setProviderUrl(string $url): void;

    /**
     * @param int|string $coId
     *
     * @return Response
     */
    public function getCompanyById(
        int|string $coId
    ): Response;

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
    ): Response;

    /**
     * @param $send
     *
     * @return bool
     */
    public function writeToOutput($send = null): bool;


    /**
     * @param null $exit
     *
     * @return bool
     */
    public function quit($exit = null): bool;

    /**
     * @param $httpCode
     *
     * @return int|false
     */
    public function httpCode($httpCode = null): int|false;

    public function exitCode($exitCode = null): int|false;

}
