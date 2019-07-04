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

namespace Wujunze\PhpGeo\Tests\Services;

use kuiper\helper\Arrays;
use Predis\Client;
use Wujunze\PhpGeo\Requests\Geo;
use Wujunze\PhpGeo\Requests\GeoCollection;
use Wujunze\PhpGeo\Requests\GeoCriteria;
use Wujunze\PhpGeo\Services\GeoInterface;
use Wujunze\PhpGeo\Services\GeoService;
use Wujunze\PhpGeo\Tests\TestCase;

class TestGeoServices extends TestCase
{
    /**
     * @var GeoService
     */
    protected static $geoService;

    /**
     * @var Client
     */
    protected static $driver;

    public static function setUpBeforeClass(): void
    {
        $config['driverClient'] = new Client([
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
        ]);

        self::$driver = $config['driverClient'];
        self::$geoService = GeoService::getInstance();
        self::$geoService->init($config);
        self::$geoService->flushDB();
    }

    public static function tearDownAfterClass(): void
    {
        self::$geoService->flushDB();
        self::$geoService = null;
    }

    public function testGeo()
    {
        $this->assertNotNull(self::$geoService);

        $this->assertInstanceOf(GeoInterface::class, self::$geoService);

        $this->assertNotNull(self::$driver);
        $this->assertInstanceOf(Client::class, self::$driver);
    }

    public function testGeoAdd()
    {
        /** @var Geo $geo */
        $geo = Arrays::assign(new Geo, ['lon' => '116.48105', 'lat' => '36.996794', 'member' => 'panda'.time()]);
        $res = self::$geoService->geoAdd('home', $geo);

        $this->assertTrue($res);
    }

    public function testGeoAddFalse()
    {
        /** @var Geo $geo */
        $geo = Arrays::assign(new Geo, ['lon' => '116.48105', 'lat' => '36.996794', 'member' => 'google']);
        $res = self::$geoService->geoAdd('home', $geo);

        $this->assertTrue($res);
        $this->assertFalse(self::$geoService->geoAdd('home', $geo));

        $this->assertEquals(1, self::$geoService->geoRemove('home', $geo->getMember()));
    }

    public function testGeoBatchAdd()
    {
        $geoCollection = new GeoCollection();
        $geoCollection->setGeos([
            Arrays::assign(new Geo, ['lon' => '116.48105', 'lat' => '36.996794', 'member' => 'cloud'.time()]),
        ]);
        $res = self::$geoService->geoBatchAdd('home', $geoCollection);

        $this->assertTrue($res);
    }

    public function testGeoDist()
    {
        /** @var Geo $geoMi */
        $geoMi = Arrays::assign(new Geo, ['lon' => '116.334255', 'lat' => '40.027400', 'member' => 'xiaomi']);
        $res = self::$geoService->geoAdd('company', $geoMi);
        $this->assertTrue($res);

        /** @var Geo $geoMeituan */
        $geoMeituan = Arrays::assign(new Geo, ['lon' => '116.489033', 'lat' => '40.007669', 'member' => 'meituan']);
        $res = self::$geoService->geoAdd('company', $geoMeituan);
        $this->assertTrue($res);

        $m = self::$geoService->geoDist('company', 'xiaomi', 'meituan', 'm');
        $this->assertIsString($m);
        $this->assertEquals("13365.8814", $m);
    }

    public function testGeoPos()
    {
        /** @var Geo $geoIreader */
        $geoIreader = Arrays::assign(new Geo, ['lon' => '116.514203', 'lat' => '39.905409', 'member' => 'ireader']);
        $res = self::$geoService->geoAdd('company', $geoIreader);
        $this->assertTrue($res);

        $geo = self::$geoService->geoPos('company', ['ireader']);
        $this->assertIsArray($geo);
        $this->assertIsString($geo[0][0]);
        $this->assertIsString($geo[0][1]);
        $this->assertIsFloat((float) $geo[0][0]);
        $this->assertIsFloat((float) $geo[0][1]);

        $this->assertEquals(round($geoIreader->getLon(), 5), round($geo[0][0], 5));
        $this->assertEquals(round($geoIreader->getLat(), 5), round($geo[0][1], 5));
    }

    public function testGeoHash()
    {
        $hash = 'wx4g52e1ce0';
        /** @var Geo $geoIreader */
        $geoIreader = Arrays::assign(new Geo, ['lon' => '116.514203', 'lat' => '39.905409', 'member' => 'ireader']);
        $res = self::$geoService->geoAdd('inc', $geoIreader);
        $this->assertTrue($res);

        $geoHash = self::$geoService->geoHash('inc', 'ireader');
        $this->assertIsArray($geoHash);
        $this->assertEquals($hash, $geoHash[0]);
    }

    /**
     * @depends  testAdd
     */
    public function testGeoRadius()
    {
        $criteria = new GeoCriteria();
        $criteria->setLong('102.55')->setLat('31.79')->setRadius(100000)->setUnit('m');
        $geos = self::$geoService->geoRadius('city', $criteria);
        $this->assertIsArray($geos);
        $this->assertEquals('小金', $geos[0]);
        $this->assertCount(7, $geos);
    }

    /**
     * @depends  testAdd
     */
    public function testGeoRadiusByMember()
    {
        $criteria = new GeoCriteria();
        $criteria->setRadius(100000)->setUnit('m')->setMember('桐柏');
        $geos = self::$geoService->geoRadiusByMember('city', $criteria);
        $this->assertIsArray($geos);
        $this->assertEquals('桐柏', $geos[0]);
        $this->assertEquals('唐河', $geos[1]);
        $this->assertCount(11, $geos);
    }

    /**
     * @depends  testAdd
     */
    public function testGeoRemove()
    {
        $res = self::$geoService->geoRemove('city', '平谷');
        $this->assertEquals(1, $res);
        $geo = self::$geoService->geoPos('city', ['平谷']);
        $this->assertNull($geo[0]);
    }

    /**
     * @depends  testAdd
     */
    public function testGeoReset()
    {
        /** @var Geo $geoIreader */
        $geoIreader = Arrays::assign(new Geo, ['lon' => '116.514203', 'lat' => '39.905409', 'member' => 'ireader']);
        self::$geoService->geoAdd('city', $geoIreader);

        $geoIreader->setLon('118.689')->setLat('36.89');
        self::$geoService->geoReset('city', $geoIreader);

        $geo = self::$geoService->geoPos('city', ['ireader']);
        $this->assertEquals(round($geoIreader->getLon(), 4), round($geo[0][0], 4));
        $this->assertEquals(round($geoIreader->getLat(), 4), round($geo[0][1], 4));
    }

    /**
     * @dataProvider additionProvider
     */
    public function testAdd($member, $lon, $lat)
    {
        /** @var Geo $geo */
        $geo = Arrays::assign(new Geo, ['lon' => $lon, 'lat' => $lat, 'member' => $member]);
        $res = self::$geoService->geoAdd('city', $geo);

        $this->assertTrue($res);
    }

    public function additionProvider()
    {
        $file = file_get_contents(__DIR__.'/../fixtrues/chinaCity.json');

        $cities = [];
        $datas = json_decode($file, true);

        foreach ($datas as $data) {
            foreach ($data['children'] as $city) {
                $cities[$city['name']] = $city;
            }
        }

        return $cities;
    }
}
