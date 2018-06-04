<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class WishaGiftControllerTest
 * @package App\Tests
 */
class WishaGiftControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerGifts
     * @param $gifts
     */
    public function testEdit($gifts)
    {
        self::markTestSkipped(
            "@nerijus todo: fix test "
        . "(Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException: "
        . "You have requested a non-existent service \"test.client\"."
        );

        $client = static::createClient();

        $editPage = $client->request('GET', '/edit/224cc6f3-c306-4e17-90e8-45bb8ea9cbe0');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $Form = $editPage->filter('#createForm')->selectButton("Save")->form();
        $Form['gift_list[firstName]'] = $gifts['firstName'][0];
        $Form['gift_list[title]'] = $gifts['title'][0];
        $Form['gift_list[gifts][0][title]'] = ucfirst(strtolower($gifts['gifts'][0]));
        $Form['gift_list[gifts][1][title]'] = ucfirst(strtolower($gifts['gifts'][1]));
        $Form['gift_list[gifts][2][title]'] = ucfirst(strtolower($gifts['gifts'][2]));
        $Form['gift_list[gifts][3][title]'] = ucfirst(strtolower($gifts['gifts'][3]));
        $Form['gift_list[gifts][4][title]'] = ucfirst(strtolower($gifts['gifts'][4]));
        $Form['gift_list[gifts][5][title]'] = ucfirst(strtolower($gifts['gifts'][5]));
        $Form['gift_list[description]'] = $gifts['description'][0];
        $client->submit($Form);

        $redirectaftersubmit = $client->followRedirect();

        $redirectaftersubmit->filter('a:contains("Edit")')->link();
        $this->assertContains(
            'Share with Friends',
            $client->getResponse()->getContent()
        );

        $expectedFirstName = $redirectaftersubmit->filter('.section-heading')->first()->text();
        $expectedTitle = $redirectaftersubmit->filter('.d-inline-block .d-inline')->first()->text();
        $expectedDescription = $redirectaftersubmit->filter('#description')->text();
        $expectedGift0 = $redirectaftersubmit->filter('#gift-title')->eq(0)->text();
        $expectedGift1 = $redirectaftersubmit->filter('#gift-title')->eq(1)->text();
        $expectedGift2 = $redirectaftersubmit->filter('#gift-title')->eq(2)->text();
        $expectedGift3 = $redirectaftersubmit->filter('#gift-title')->eq(3)->text();
        $expectedGift4 = $redirectaftersubmit->filter('#gift-title')->eq(4)->text();
        $expectedGift5 = $redirectaftersubmit->filter('#gift-title')->eq(5)->text();

        $this->assertEquals(
            strtok($expectedFirstName, ' '),
            $gifts['firstName'][0],
            'First Name'
        );
        $this->assertEquals(
            $expectedTitle,
            $gifts['title'][0],
            'Title'
        );
        $this->assertEquals(
            $expectedGift0,
            ucfirst(strtolower($gifts['gifts'][0])),
            'first gift'
        );
        $this->assertEquals(
            $expectedGift1,
            ucfirst(strtolower($gifts['gifts'][1])),
            'second gift'
        );
        $this->assertEquals(
            $expectedGift2,
            ucfirst(strtolower($gifts['gifts'][2])),
            'third gift'
        );
        $this->assertEquals(
            $expectedGift3,
            ucfirst(strtolower($gifts['gifts'][3])),
            'fourth gift'
        );
        $this->assertEquals(
            $expectedGift4,
            ucfirst(strtolower($gifts['gifts'][4])),
            'fifth gift'
        );
        $this->assertEquals(
            $expectedGift5,
            ucfirst(strtolower($gifts['gifts'][5])),
            'sixth gift'
        );
        $this->assertEquals(
            6,
            $redirectaftersubmit->filter('#gift-title')->count(),
            'Added 6 gifts'
        );
        $this->assertEquals(
            $expectedDescription,
            $gifts['description'][0],
            'Description'
        );
    }

    public function providerGifts()
    {
        return [
            [
                [
                    'gifts' => [
                        0 => 'Reusable Coffee Cup',
                        1 => 'Slush Puppie Machine',
                        2 => 'Infinity Light',
                        3 => 'Graphics Tablet',
                        4 => 'Standup Comedy Tickets',
                        5 => 'Engraved Glass'
                    ],
                    'title' => [
                        0 => 'Crazy on the coast'
                    ],
                    'firstName' => [
                        0 => 'John'
                    ],
                    'description' => [
                        0 => 'Public gift list'
                    ]
                ]
            ]
        ];
    }
}
