<?php

namespace App\Services;

use App\Services\LitigationFeeService;

class LitigationCalculatorHelpBaseFeeService
{
    public function __construct(private LitigationFeeService $litigationFeeService) {}

    public function calculateHelpBaseFee(array $data)
    {
        $settings = $this->litigationFeeService->handle();

        $procedureType = $data['proceduer_type'] ?? null;
        $courtLevel = $data['court_level'] ?? null;
        $fallbackBase = $settings['fallback_base']->setting_value;

        //Eljárás típus meghatározása, kiválasztása
        $isLitigation = in_array($procedureType, ['litigation', 'non_litigious', 'legal_remedy', 'enforcement']);
        $procedureCategory = $isLitigation ? 'litigation' : 'non_litigious';

        //adatbázisban tárolt adatok alapján a megfelelő kisebbségi illetékalap kiválasztása
        $helpBaseFee = 0;
        foreach($fallbackBase as $base){
            if($base['court_level'] === $courtLevel && $base['procedure_category'] === $procedureCategory){
                $helpBaseFee = $base[$procedureCategory];
                break;
            }
        }

        return $helpBaseFee;

    }

}
