<?php

use PHPUnit\Framework\TestCase;
use App\Basket;

class BasketTest extends TestCase
{

    private array $catalogue;
    private array $deliveryRules;
    private array $offers;

    protected function setUp(): void
    {
        $this->catalogue = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95,
        ];

        $this->deliveryRules = [
            50 => 4.95,
            90 => 2.95,
            PHP_INT_MAX => 0,
        ];

        $this->offers = [
            'R01' => 'buy one get second half price',
        ];
    }

    public function testBasketWithB01AndG01()
    {
        $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
        $basket->add('B01');
        $basket->add('G01');
        $this->assertSame('37.85', $basket->total());
    }

    public function testBasketWithTwoR01()
    {
        $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
        $basket->add('R01');
        $basket->add('R01');
        $this->assertSame('54.37', $basket->total());
    }

    public function testBasketWithR01AndG01()
    {
        $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
        $basket->add('R01');
        $basket->add('G01');
        $this->assertSame('60.85', $basket->total());
    }

    public function testBasketWithMultipleItems()
    {
        $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        $this->assertSame('98.27', $basket->total());
    }

    public function testInvalidProductThrowsException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid product code: X01');

        $basket = new Basket($this->catalogue, $this->deliveryRules, $this->offers);
        $basket->add('X01');
    }
}
