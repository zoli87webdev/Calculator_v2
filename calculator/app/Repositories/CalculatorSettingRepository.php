<?php

namespace App\Repositories;

use App\Models\CalculatorSetting;
use Illuminate\Support\Arr;

class CalculatorSettingRepository
{
    /**
     * Get setting value by key.
     *
     * @param string $key
     * @return array
     */
    public function getByKey(string $key): CalculatorSetting
    {
        return CalculatorSetting::where('setting_key', $key)->firstOrFail();

    }

    public function getProcedureTypes(): array
    {
        //eljárástípusok
        return $this->getByKey('litigation_fee_procedure_types')->setting_value;
    }

    public function getCourtLevels(): array
    {
        //bírósági szint
        return $this->getByKey('litigation_fee_court_levels')->setting_value;
    }

    public function getSpecialCaseTypes(): array
    {
        //különleges eljárás típusok
        return $this->getByKey('litigation_fee_special_case_types')->setting_value;
    }

    //kiegészitve, ellenőrizni kell_________________________________________________________________________________________
    public function additionalOptions(): array
    {
        //további opciók
        return $this->getByKey('litigation_fee_additional_options');
    }

    public function fallbackBase(): array
    {
        //kisegítő illetékalap
        return $this->getByKey('litigation_fee_fallback_base');
    }

    public function tiered(): array
    {
        //sávos illeték rendszer
        return $this->getByKey('litigation_fee_tiered');
    }
    public function fixedSpecials(): array
    {
        // különleges fix illetékek
        return $this->getByKey('litigation_fee_fixed_specials');
    }
    public function discountRules(): array
    {
        //kedvezmények
        return $this->getByKey('litigation_fee_discount_rules');
    }
}
