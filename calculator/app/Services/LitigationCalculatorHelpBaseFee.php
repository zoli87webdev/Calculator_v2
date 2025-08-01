<?php

namespace App\Services;

use App\Services\LitigationFeeService;

class LitigationCalculatorHelpBaseFee
{
    public function __construct(private LitigationFeeService $litigationFeeService) {}

    public function calculateHelpBaseFee(array $data)
    {
        $settings = $this->litigationFeeService->handle();


    }

}
