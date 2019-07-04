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

class Geo implements Arrayable
{
    use ArrayableTrait;

    /**
     * @var string
     */
    private $member;

    /**
     * @var string
     */
    private $lon;

    /**
     * @var string
     */
    private $lat;

    /**
     * @return string
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param  string $member
     * @return Geo
     */
    public function setMember(string $member): Geo
    {
        $this->member = $member;

        return $this;
    }

    /**
     * @return string
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param  string $lon
     * @return Geo
     */
    public function setLon(string $lon): Geo
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param  string $lat
     * @return Geo
     */
    public function setLat(string $lat): Geo
    {
        $this->lat = $lat;

        return $this;
    }
}
