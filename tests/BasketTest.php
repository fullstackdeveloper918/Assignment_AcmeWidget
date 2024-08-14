<?php

use PHPUnit\Framework\TestCase;
use Acme\WidgetBasket\Basket;

class BasketTest extends TestCase
{
    private $productCatalogue;
    private $deliveryRules;
    private $offers;

    protected function setUp(): void
    {
        $this->productCatalogue = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95,
        ];

        $this->deliveryRules = [
            50 => 4.95,
            90 => 2.95,
        ];

        $this->offers = [
            'R01' => [
                'type' => 'buy_one_get_half_off',
            ],
        ];
    }

    public function testTotalB01G01()
    {
        $basket = new Basket($this->productCatalogue, $this->deliveryRules, $this->offers);
        $basket->add('B01');
        $basket->add('G01');
        $this->assertEquals(37.85, $basket->total());
    }

    public function testTotalR01R01()
    {
        $basket = new Basket($this->productCatalogue, $this->deliveryRules, $this->offers);
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(54.37, $basket->total(), '', 0.02);
    }

    public function testTotalR01G01()
    {
        $basket = new Basket($this->productCatalogue, $this->deliveryRules, $this->offers);
        $basket->add('R01');
        $basket->add('G01');
        $this->assertEquals(60.85, $basket->total());
    }

    public function testTotalB01B01R01R01R01()
    {
        $basket = new Basket($this->productCatalogue, $this->deliveryRules, $this->offers);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(98.27, $basket->total(), '', 0.02);  // Allowing a delta of 0.02
    }
}
