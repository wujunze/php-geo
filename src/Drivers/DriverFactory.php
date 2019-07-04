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

use InvalidArgumentException;

class DriverFactory
{
    /**
     * @param \Redis|\Predis\Client|string $connection Connection or DSN or Store short name
     *
     * @return DriverInterface
     */
    public static function createDriver($connection): DriverInterface
    {
        if (
            $connection instanceof \Redis ||
            $connection instanceof \RedisArray ||
            $connection instanceof \RedisCluster ||
            $connection instanceof \Predis\Client
        ) {
            return new RedisDriver($connection);
        }

        if (!\is_string($connection)) {
            throw new InvalidArgumentException(sprintf('Unsupported Connection: %s.', \get_class($connection)));
        }
        switch (true) {
            case 'file' === $connection:
                return new FileDriver();
            case 'mem' === $connection:
                return new MemDriver();
            case 'apcu' === $connection:
                return new ApcuDriver();
            default:
                throw new InvalidArgumentException(sprintf('Unsupported Connection: %s.', $connection));
        }
    }
}
