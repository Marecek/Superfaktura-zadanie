<?php

namespace CoById\Interface;

use CoById\Exception\ExcError;
use CoById\Models\Response;

interface CoByIdInterface
{
    /**
     * @return string
     */
    public function getProviderUrl(): string;

    /**
     * @param string $providerUrl
     *
     * @return void
     */
    public function setProviderUrl(string $providerUrl): void;

    /**
     * @param int|string $coId
     *
     * @return ResponseInterface|Response
     */
    public function getCompanyById(
        int|string $coId
    ): ResponseInterface|Response;

    /**
     * @param int|string $coId
     * @param string|array<string> $data
     *
     * @return  ResponseInterface|Response
     * @throws ExcError
     */
    public function postCompanyById(
        int|string $coId,
        string|array $data
    ): ResponseInterface|Response;



    /**
     * @param null $exit
     *
     * @return bool
     */
    public function quit($exit = null): bool;


}
