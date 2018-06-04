<?php

namespace App\Tests\Service;

use App\Controller\GiftListsController;
use App\Service\ReservedGiftCookieResolver;
use PHPUnit\Framework\TestCase;

class ReservedGiftCookieResolverTest extends TestCase
{
    private $cookieResolver;

    protected function setUp()
    {
        $this->cookieResolver = new ReservedGiftCookieResolver();
    }
    public function getFormatData()
    {
        return [
            'reserved_gifts' => ['24f2857d1-23f4-4fea-bd4b-7c6c11adde4b', '71872478-8771-4c47-9d4e-94da6fbb881b']

        ];
    }

    /**
     * @dataProvider getFormatData
     * @param $id
     * @param $reserveToken
     * @return string
     */

    public function testAddGift($id, $reserveToken)
    {
        $cookie = json_encode([$id => $reserveToken]);

        $result = $this->cookieResolver->addGift($cookie, $id, $reserveToken);
        $this->assertNotNull($result, 'Cookie is set');
        $this->assertJsonStringEqualsJsonString($result->getValue(), $cookie);
        $this->assertEquals('reserved_gifts', GiftListsController::RESERVED_GIFTS_COOKIE);
//        $this->assertEquals([$id => $reserveToken], json_decode($result->getValue(), true));
        $this->assertInternalType("array", json_decode($result->getValue(), true));
    }

    /**
     * @dataProvider getFormatData
     * @param $id
     * @param $reserveToken
     */
    public function testRemoveGift($id, $reserveToken)
    {
        $cookie = json_encode([$id => $reserveToken]);
        $result = $this->cookieResolver->removeGift($cookie, $id);
        $value = json_decode($result->getValue(), true);
        $this->assertArrayNotHasKey($id, $value);
    }

    /**
     * @dataProvider getFormatData
     * @param $id
     * @param $reserveToken
     */
    public function testisReservedForTime($id, $reserveToken)
    {
        $reservedAt = new \DateTime('+ 10 minutes');
        $cookie = json_encode([$id => $reserveToken]);
        $result = $this->cookieResolver->isReservedForTime($cookie, $id, $reserveToken, $reservedAt);
        $this->assertTrue($result);
    }
    /**
     * @dataProvider getFormatData
     * @param $id
     * @param $reserveToken
     */
    public function testisReserved($id, $reserveToken)
    {
        $cookie = json_encode([$id => $reserveToken]);
        $result = $this->cookieResolver->isReserved($cookie, $id, $reserveToken);
        $this->assertTrue($result);
    }
}
