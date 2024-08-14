<?php

namespace Acme\WidgetBasket;

class Basket
{
    private $products = [];
    private $productCatalogue;
    private $deliveryRules;
    private $offers;

    public function __construct($productCatalogue, $deliveryRules, $offers)
    {
        $this->productCatalogue = $productCatalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add(string $productCode)
    {
        if (!isset($this->productCatalogue[$productCode])) {
            throw new \Exception("Product code $productCode not found in catalogue");
        }

        if (!isset($this->products[$productCode])) {
            $this->products[$productCode] = 0;
        }

        $this->products[$productCode]++;
    }

    public function total(): float
    {
        $total = 0.0;

        foreach ($this->products as $productCode => $quantity) {
            $price = $this->productCatalogue[$productCode];
            $total += $price * $quantity;

            if (isset($this->offers[$productCode])) {
                $total -= $this->applyOffer($productCode, $quantity);
            }
        }

        $total += $this->applyDelivery($total);

        return round($total, 2);
    }

    private function applyOffer(string $productCode, int $quantity): float
    {
        $discount = 0.0;
        $offer = $this->offers[$productCode];

        if ($offer['type'] === 'buy_one_get_half_off') {
            $price = $this->productCatalogue[$productCode];
            // Calculate discount
            $discount = floor($quantity / 2) * ($price / 2);
        }

        return round($discount, 2);
    }

    private function applyDelivery(float $total): float
    {
        foreach ($this->deliveryRules as $threshold => $charge) {
            if ($total < $threshold) {
                return $charge;
            }
        }

        return 0.0;
    }
}
