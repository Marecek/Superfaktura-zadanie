<?php

namespace CoById\Factory;

use CoById\Interface\RequestFactoryInterface;
use CoById\Interface\RequestInterface;
use CoById\Models\Request;

class RequestFactory implements RequestFactoryInterface
{
    /**
     * @param string $url
     *
     * @return RequestInterface
     */
    public function create(string $url): RequestInterface
    {
        return new Request($url, $this);
    }
}
