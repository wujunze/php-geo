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

namespace Wujunze\PhpGeo\Services;

use InvalidArgumentException;
use Predis\Client;
use Wujunze\PhpGeo\Drivers\DriverFactory;
use Wujunze\PhpGeo\Drivers\RedisDriver;
use Wujunze\PhpGeo\Requests\Geo;
use Wujunze\PhpGeo\Requests\GeoCollection;
use Wujunze\PhpGeo\Requests\GeoCriteria;

class GeoService implements GeoInterface
{
    /**
     * @var bool
     */
    private $isInit = false;

    /**
     * @var $this
     */
    private static $instance;

    /**
     * @var RedisDriver
     */
    private $driver;

    /**
     * @var Client
     */
    private $client;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function init(array $config)
    {
        if (!$this->isInit) {
            if (empty($config['driverClient'])) {
                throw  new InvalidArgumentException("not found redis client");
            }

            $this->driver = DriverFactory::createDriver($config['driverClient']);
            $this->client = $this->driver->getClient();

            $this->isInit = true;
        }
    }

    /**
     * @inheritDoc
     */
    public static function getInstance(): GeoInterface
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @inheritDoc
     */
    public function geoAdd(string $key, Geo $geo): bool
    {
        return (bool) $this->client->geoadd($key, $geo->getLon(), $geo->getLat(), $geo->getMember());
    }

    /**
     * @inheritDoc
     */
    public function geoBatchAdd(string $key, GeoCollection $geoCollection): bool
    {
        $res = [];
        foreach ($geoCollection->getGeos() as $geo) {
            $res[] = $this->client->geoadd($key, $geo->getLon(), $geo->getLat(), $geo->getMember());
        }

        if (in_array(0, $res, true)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function geoDist(string $key, string $fromMember, string $toMember, string $unit = 'm'): string
    {
        return $this->client->geodist($key, $fromMember, $toMember, $unit);
    }

    /**
     * @inheritDoc
     */
    public function geoPos(string $key, array $member): array
    {
        return $this->client->geopos($key, $member);
    }

    /**
     * @inheritDoc
     */
    public function geoHash(string $key, string $member): array
    {
        return $this->client->geohash($key, $member);
    }

    /**
     * @inheritDoc
     */
    public function geoRadius(string $key, GeoCriteria $geoCriteria): array
    {
        return $this->client->georadius(
            $key,
            $geoCriteria->getLong(),
            $geoCriteria->getLat(),
            $geoCriteria->getRadius(),
            $geoCriteria->getUnit()
        );
    }

    /**
     * @inheritDoc
     */
    public function geoRadiusByMember(string $key, GeoCriteria $geoCriteria): array
    {
        return $this->client->georadiusbymember(
            $key,
            $geoCriteria->getMember(),
            $geoCriteria->getRadius(),
            $geoCriteria->getUnit()
        );
    }

    /**
     * @inheritDoc
     */
    public function geoRemove(string $key, string $member): int
    {
        return $this->client->zrem($key, $member);
    }

    /**
     * @inheritDoc
     */
    public function geoReset(string $key, Geo $geo): bool
    {
        $this->client->zrem($key, $geo->getMember());

        return $this->geoAdd($key, $geo);
    }

    /**
     * @return mixed
     */
    public function flushDB()
    {
        return $this->client->flushdb();
    }
}
