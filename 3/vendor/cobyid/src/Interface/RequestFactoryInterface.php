<?php

namespace CoById\Interface;

interface RequestFactoryInterface
{
    public function create(string $url): RequestInterface;
}
