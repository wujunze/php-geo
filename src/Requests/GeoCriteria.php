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

namespace Wujunze\PhpGeo\Requests;

use winwin\support\Arrayable;
use winwin\support\ArrayableTrait;

class GeoCriteria implements Arrayable
{
    use ArrayableTrait;

    /**
     * @var int
     */
    private $radius;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var bool
     */
    private $withCoord;

    /**
     * @var bool
     */
    private $withDist;

    /**
     * @var bool
     */
    private $withHash;

    /**
     * @var int
     */
    private $count;

    /**
     * @var string
     */
    private $sort;

    /**
     * @var string
     */
    private $store;

    /**
     * @var string
     */
    private $storeDist;

    /**
     * @var string
     */
    private $long;

    /**
     * @var string
     */
    private $lat;

    /**
     * @var string
     */
    private $member;

    /**
     * @return string
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param  string      $member
     * @return GeoCriteria
     */
    public function setMember(string $member): GeoCriteria
    {
        $this->member = $member;

        return $this;
    }

    /**
     * @return int
     */
    public function getRadius()
    {
        return $this->radius;
    }

    /**
     * @param  int         $radius
     * @return GeoCriteria
     */
    public function setRadius(int $radius): GeoCriteria
    {
        $this->radius = $radius;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param  string      $unit
     * @return GeoCriteria
     */
    public function setUnit(string $unit): GeoCriteria
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithCoord()
    {
        return $this->withCoord;
    }

    /**
     * @param  bool        $withCoord
     * @return GeoCriteria
     */
    public function setWithCoord(bool $withCoord): GeoCriteria
    {
        $this->withCoord = $withCoord;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithHash()
    {
        return $this->withHash;
    }

    /**
     * @param  bool        $withHash
     * @return GeoCriteria
     */
    public function setWithHash(bool $withHash): GeoCriteria
    {
        $this->withHash = $withHash;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param  int         $count
     * @return GeoCriteria
     */
    public function setCount(int $count): GeoCriteria
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param  string      $sort
     * @return GeoCriteria
     */
    public function setSort(string $sort): GeoCriteria
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return string
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param  string      $store
     * @return GeoCriteria
     */
    public function setStore(string $store): GeoCriteria
    {
        $this->store = $store;

        return $this;
    }

    /**
     * @return string
     */
    public function getStoreDist()
    {
        return $this->storeDist;
    }

    /**
     * @param  string      $storeDist
     * @return GeoCriteria
     */
    public function setStoreDist(string $storeDist): GeoCriteria
    {
        $this->storeDist = $storeDist;

        return $this;
    }

    /**
     * @return string
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * @param  string      $long
     * @return GeoCriteria
     */
    public function setLong(string $long): GeoCriteria
    {
        $this->long = $long;

        return $this;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param  string      $lat
     * @return GeoCriteria
     */
    public function setLat(string $lat): GeoCriteria
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithDist()
    {
        return $this->withDist;
    }

    /**
     * @param  bool        $withDist
     * @return GeoCriteria
     */
    public function setWithDist(bool $withDist): GeoCriteria
    {
        $this->withDist = $withDist;

        return $this;
    }
}
