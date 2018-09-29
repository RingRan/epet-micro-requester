<?php

namespace Epet\MicroRequest;

use Epet\MicroRequest\Adapter\HttpClientAdapterInterface;

/**
 * Interface HttpClientInterface
 *
 * @package Epet\MicroRequest
 */
interface HttpClientInterface extends HttpClientAdapterInterface
{
    /**
     * Get method
     *
     * @param string   $url
     * @param array    $option
     * @param callable $callback
     *
     * @return mixed
     */
    public function get(string $url, array $option = [], callable $callback = null);

    /**
     * Post Method
     *
     * @param string   $url
     * @param array    $data
     * @param array    $option
     * @param callable $callback
     *
     * @return mixed
     */
    public function post(string $url, array $data, array $option = [], callable $callback = null);

    /**
     * Put Method
     *
     * @param string   $url
     * @param array    $data
     * @param array    $option
     * @param callable $callback
     *
     * @return mixed
     */
    public function put(string $url, array $data, array $option = [], callable $callback = null);

    /**
     * Delete Method
     *
     * @param string   $url
     * @param array    $data
     * @param array    $option
     * @param callable $callback
     *
     * @return mixed
     */
    public function delete(string $url, array $data, array $option = [], callable $callback = null);
}
