<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 6.12.2016
 * Time: 16:07
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tests\Neo\NasaBundle\Document;

use Neo\NasaBundle\Document\Neo;

class NeoTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $neo = new Neo();
        $neo->setDate(date("Y-m-d"));
        $neo->setName("test name 2");
        $neo->setIsHazardous(false);
        $neo->setReference(2234567);
        $neo->setSpeed(6000);
        $this->assertSame(
            [
                'reference' => 2234567,
                'name' => 'test name 2',
                'date' => date("Y-m-d"),
                'speed' => 6000,
                'is_hazardous' => false
            ], $neo->toArray());
    }
}
