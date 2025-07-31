<?php

namespace App\Repositories;

use App\Models\CalculatorSetting;

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
        return $this->getByKey('litigation_fee_procedure_types')->setting_value;
    }

    public function getCourtLevels(): array
    {
        return $this->getByKey('litigation_fee_court_levels')->setting_value;
    }

    public function getSpecialCaseTypes(): array
    {
        return $this->getByKey('litigation_fee_special_case_types')->setting_value;
    }
}
