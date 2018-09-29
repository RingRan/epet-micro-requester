<?php

namespace Epet\MicroRequest\Adapter;

/**
 * Interface HttpClientAdapterInterface
 *
 * @package Epet\MicroRequest\Adapter
 */
interface HttpClientAdapterInterface
{
    public function setUrl(string $url): void;

    public function setHost(string $host): void;

    public function setPort(int $port): void;

    public function setPath(string $path): void;

    public function setTimeout(int $timeout): void;

    public function setMethod(string $method): void;

    public function setHeader(array $header = []): void;

    public function setData($data);

    public function execute();
}
