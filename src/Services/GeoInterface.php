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

use Wujunze\PhpGeo\Requests\Geo;
use Wujunze\PhpGeo\Requests\GeoCollection;
use Wujunze\PhpGeo\Requests\GeoCriteria;

/**
 * Interface GeoInterface
 */
interface GeoInterface
{
    /**
     * @return GeoInterface
     */
    public static function getInstance(): GeoInterface;

    /**
     * @param  array $config
     * @return mixed
     */
    public function init(array $config);

    /**
     * add a geo
     *
     * @param  string $key
     * @param  Geo    $geo
     * @return bool
     */
    public function geoAdd(string $key, Geo $geo): bool;

    /**
     * @param  string        $key
     * @param  GeoCollection $geoCollection
     * @return bool
     */
    public function geoBatchAdd(string $key, GeoCollection $geoCollection): bool;

    /**
     * @param  string $key
     * @param  string $fromMember
     * @param  string $toMember
     * @param  string $unit       m/km
     * @return string
     */
    public function geoDist(string $key, string $fromMember, string $toMember, string $unit = 'm'): string ;

    /**
     * @param  string $key
     * @param  array  $member
     * @return array
     */
    public function geoPos(string $key, array $member): array;

    /**
     * @param  string $key
     * @param  string $member
     * @return array
     */
    public function geoHash(string $key, string $member): array;

    /**
     * @param  string      $key
     * @param  GeoCriteria $geoCriteria
     * @return array
     */
    public function geoRadius(string $key, GeoCriteria $geoCriteria): array;

    /**
     * @param  string      $key
     * @param  GeoCriteria $geoCriteria
     * @return array
     */
    public function geoRadiusByMember(string $key, GeoCriteria $geoCriteria): array;

    /**
     * @param  string $key
     * @param  string $member
     * @return int
     */
    public function geoRemove(string $key, string $member): int;

    /**
     * @param  string $key
     * @param  Geo    $geo
     * @return bool
     */
    public function geoReset(string $key, Geo $geo): bool;
}
