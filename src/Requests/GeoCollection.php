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

class GeoCollection implements Arrayable
{
    use ArrayableTrait;
    /**
     * @var int
     */
    private $total;

    /**
     * @var Geo[]
     */
    private $geos = [];

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param  int           $total
     * @return GeoCollection
     */
    public function setTotal(int $total): GeoCollection
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Geo[]
     */
    public function getGeos()
    {
        return $this->geos;
    }

    /**
     * @param  Geo[]         $geos
     * @return GeoCollection
     */
    public function setGeos(array $geos): GeoCollection
    {
        $this->geos = $geos;

        return $this;
    }
}
