<?php declare(strict_types=1);
/**
 *
 * This file is part of the php-geo package.
 *
 * (c) Panda <itwujunze@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Wujunze\PhpGeo\Drivers;

use Predis\Client;

class RedisDriver implements DriverInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct($connect)
    {
        $this->client = $connect;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param  Client      $client
     * @return RedisDriver
     */
    public function setClient(Client $client): RedisDriver
    {
        $this->client = $client;

        return $this;
    }

    public function __call($name, $arguments)
    {
        return $this->client->{$name}($arguments);
    }
}
