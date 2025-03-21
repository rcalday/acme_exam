<?php

namespace App;

use Exception;

class Basket
{
    private $catalogue;
    private $deliveryRules;
    private $offers;
    private $items = [];

    public function __construct($catalogue, $deliveryRules, $offers)
    {
        $this->catalogue = $catalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add($productCode)
    {
        if (!isset($this->catalogue[$productCode])) {
            throw new Exception("Invalid product code: $productCode");
        }
        $this->items[] = $productCode;
    }

    public function total()
    {
        $subtotal = 0.0;
        $itemCounts = array_count_values($this->items);

        foreach ($itemCounts as $code => $quantity) {
            if ($code === 'R01' && isset($this->offers['R01'])) {
                $fullPriceItems = intdiv($quantity, 2) + ($quantity % 2); // Full price items
                $halfPriceItems = intdiv($quantity, 2); // Half price items
                $halfPrice = $this->catalogue[$code] / 2; // Half price calculation

                // Add the exact prices without rounding
                $subtotal += ($fullPriceItems * $this->catalogue[$code]) + ($halfPriceItems * $halfPrice);
            } else {
                $subtotal += $quantity * $this->catalogue[$code];
            }
        }

        // Apply strict rounding after calculating the total
        $subtotal = floor($subtotal * 100) / 100; // Floor the subtotal to 2 decimal places

        $deliveryCharge = $this->calculateDelivery($subtotal);

        // Ensure that the final total has 2 decimal places strictly
        return number_format($subtotal + $deliveryCharge, 2, '.', '');
    }

    private function calculateDelivery($subtotal)
    {
        foreach ($this->deliveryRules as $threshold => $cost) {
            if ($subtotal < $threshold) {
                return $cost;
            }
        }
        return 0;
    }
}
