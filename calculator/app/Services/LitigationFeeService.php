<?php

namespace App\Services;

use App\Repositories\CalculatorSettingRepository;

class LitigationFeeService
{
    private CalculatorSettingRepository $repository;

    public function __construct(CalculatorSettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all fee settings.
     *
     * @return array
     */
    public function handle(): array
    {
        return [
            'procedure_types' => $this->repository->getByKey('litigation_fee_procedure_types'),
            'court_levels' => $this->repository->getByKey('litigation_fee_court_levels'),
            'additional_options' => $this->repository->getByKey('litigation_fee_additional_options'),
            'special_case_types' => $this->repository->getByKey('litigation_fee_special_case_types'),
            'fallback_base' => $this->repository->getByKey('litigation_fee_fallback_base'),
        ];
    }
}
