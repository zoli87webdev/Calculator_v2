<?php

namespace App\Services;

use App\Services\LitigationFeeService;

class LitigationCalculatorBaseFee
{
    public function __construct(private LitigationFeeService $litigationFeeService) {}

    /*
        Alapdij számitás
        Az alapilleték sávos rendeszere (ltv. 42. § (1)a bekezdés)
    */
    public function calculateBaseFee(array $data): float|int
    {
        $settings = $this->litigationFeeService->handle();

        // 1. Sávos illeték számítása
        $fee = $this->calculateTieredFee($settings['tiered'], $data['amount'] ?? 0);

        // 2. Alapilleték ellenőrzése
        $fee = $this->fallbackBase($fee, $settings['fallback_base']);

        // 3. Ingatlan kedvezmény alkalmazása
        if ($this->shouldRealEstateDiscount($data)) {
            $fee = $this->applyEstateDiscount($fee, $data['amount'] ?? 0);
        }

        return $fee;
    }


    // Kiszámítja a sávos illetéket az összeg alapján a megfelelő sávban
    private function calculateTieredFee(array $tiered, float $amount): float
    {
        foreach($tiered as [$min, $max, $fixed, $rate]){
            if($amount >= $min && $amount <= $max){
                return $fixed + ($amount - $min) * $rate;
            }
        }
        return 0;
    }

    // Ellenőrzi és alkalmazza a minimális alapilletéket, ha a számított összeg alacsonyabb
    private function fallbackBase(float $fee, float $fallbackBase): float
    {
        return max($fee, $fallbackBase);
    }


    //Megállapítja, hogy az ingatlan kedvezményt alkalmazni kell-e az adott összegre és feltételekre
    private function shouldRealEstateDiscount(array $data): bool
    {
        $realEstate = $data['additional_options']['real_estate'] ?? false;
        $amount = $data['amount'] ?? 0;

        return $realEstate && $amount > 10000001 && $amount <= 250000000;
    }

    //Alkalmazza az ingatlan kedvezményt és ellenőrzi a minimális illetéket
    private function applyEstateDiscount(float $fee, float $amount): float
    {
        $discountedFee = $fee * 0.5;
        return max($discountedFee, 489500);
    }
}
