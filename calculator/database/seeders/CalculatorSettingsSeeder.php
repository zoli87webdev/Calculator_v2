<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalculatorSetting;

class CalculatorSettingsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getSettings() as $setting) {
            CalculatorSetting::create([
                'setting_label' => $setting['setting_label'],
                'setting_key' => $setting['setting_key'],
                'setting_value' => $setting['setting_value']

            ]);
        }
    }

    /**
     * List of calculator settings in English.
     *
     * @return array
     */
    protected function getSettings(): array
    {
        return [

            [
                'setting_label' => 'Eljárás típusok',
                'setting_key' => 'litigation_fee_procedure_types',
                'setting_value' => [
                    ['key' => 'litigious', 'label' => 'Peres'],
                    ['key' => 'non_litigious', 'label' => 'Nem peres'],
                    ['key' => 'legal_remedy', 'label' => 'Jogorvoslat'],
                    ['key' => 'enforcement', 'label' => 'Végrehajtás'],
                ],
            ],

            [
                'setting_label' => 'Bíróság szintje',
                'setting_key' => 'litigation_fee_court_levels',
                'setting_value' => [
                    ['key' => 'district_court', 'label' => 'Járásbíróság'],
                    ['key' => 'regional_court_first_instance', 'label' => 'Törvényszék-első fok'],
                    ['key' => 'regional_court_appeal', 'label' => 'Törvényszék-fellebbezés'],
                    ['key' => 'court_of_appeal', 'label' => 'Ítélőtábla-fellebbezés'],
                    ['key' => 'supreme_court_appeal', 'label' => 'Kúria-fellebbezés'],
                    ['key' => 'supreme_court_review', 'label' => 'Kúria-felülvizsgálat'],
                ],
            ],

            [
                'setting_label' => 'További lehetőségek',
                'setting_key' => 'litigation_fee_additional_options',
                'setting_value' => [
                    ['key' => 'real_estate', 'label' => 'Lakásügy'],
                    ['key' => 'pre_evidence', 'label' => 'Előzetes bizonyítás'],
                    ['key' => 'fmh', 'label' => 'FMH beszámítás'],
                    ['key' => 'discounts', 'label' => 'Kedvezmények'],
                ],
            ],

            [
                'setting_label' => 'Különleges eljárás típusok',
                'setting_key' => 'litigation_fee_special_case_types',
                'setting_value' => [
                    ['key' => 'opposition_to_payment_order', 'label' => 'Bírósági meghagyás elleni ellentmondás'],
                    ['key' => 'conciliation_attempt', 'label' => 'Egyezségi kísérlet (pk)'],
                    ['key' => 'enforcement_procedure', 'label' => 'Végrehajtási eljárás'],
                    ['key' => 'installment_after_judgment', 'label' => 'Részletfizetés / Halasztás (ítélet után)'],
                    ['key' => 'fine_in_installments', 'label' => 'Pénzbírság részletekben'],
                    ['key' => 'other_non_litigious', 'label' => 'Egyéb nemperes eljárás'],
                ],
            ],


            [
                'setting_label' => 'Kisegítő illetékalap (Itv. 39. § (3))',
                'setting_key' => 'litigation_fee_fallback_base',
                'setting_value' => [
                    ['court_level' => 'district_court', 'litigious' => 350000, 'non_litigious' => 200000],
                    ['court_level' => 'regional_court_first_instance', 'litigious' => 600000, 'non_litigious' => 350000],
                    ['court_level' => 'regional_court_appeal', 'litigious' => 300000, 'non_litigious' => 170000],
                    ['court_level' => 'court_of_appeal', 'litigious' => 600000, 'non_litigious' => 300000],
                    ['court_level' => 'supreme_court_appeal', 'litigious' => 500000, 'non_litigious' => null],
                    ['court_level' => 'supreme_court_review', 'litigious' => 700000, 'non_litigious' => null],
                ],
            ],

            [
                'setting_label' => 'Sávos illetékek (Itv. 42. § (1) a)',
                'setting_key' => 'litigation_fee_tiered',
                'setting_value' => [
                    ['min' => 0, 'max' => 300000, 'base_fee' => 18000, 'percent' => 0],
                    ['min' => 300001, 'max' => 3000000, 'base_fee' => 18000, 'percent' => 4.5],
                    ['min' => 3000001, 'max' => 10000000, 'base_fee' => 139500, 'percent' => 5],
                    ['min' => 10000001, 'max' => 30000000, 'base_fee' => 489500, 'percent' => 7],
                    ['min' => 30000001, 'max' => 50000000, 'base_fee' => 1889500, 'percent' => 4.5],
                    ['min' => 50000001, 'max' => 100000000, 'base_fee' => 2789500, 'percent' => 2.5],
                    ['min' => 100000001, 'max' => 250000000, 'base_fee' => 4039500, 'percent' => 2],
                    ['min' => 250000001, 'max' => 500000000, 'base_fee' => 7039500, 'percent' => 0.5],
                    ['min' => 500000001, 'max' => null, 'base_fee' => 8289500, 'percent' => 0.5],
                ],
            ],

            [
                'setting_label' => 'Különleges fix illeték',
                'setting_key' => 'litigation_fee_fixed_specials',
                'setting_value' => [
                    ['type' => 'opposition_to_payment_order', 'percent' => 3, 'min' => 5000, 'max' => 750000],
                    ['type' => 'conciliation_attempt', 'percent' => 1, 'min' => 3000, 'max' => 15000],
                    ['type' => 'enforcement_procedure', 'percent' => 1, 'min' => 5000, 'max' => 350000],
                    ['type' => 'installment_after_judgment', 'percent' => 1, 'min' => 5000, 'max' => 15000],
                    ['type' => 'fine_in_installments', 'percent' => 1, 'min' => 5000, 'max' => 18000],
                    ['type' => 'other_non_litigious', 'percent' => 3, 'min' => 5000, 'max' => 250000],
                ],
            ],

            [
                'setting_label' => 'Kedvezmények',
                'setting_key' => 'litigation_fee_discount_rules',
                'setting_value' => [
                    ['type' => 'housing_case', 'reduction_percent' => 50, 'min_fee' => 489500],
                    ['type' => 'preliminary_evidence', 'reduction_percent' => 50],
                    ['type' => 'payment_order_deduction', 'reduction_type' => 'subtractive'],
                ],
            ]
        ];
    }
}

