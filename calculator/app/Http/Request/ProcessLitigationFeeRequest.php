<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\CalculatorSettingRepository;
class ProcessLitigationFeeRequest extends FormRequest
{
    private CalculatorSettingRepository $calculatorSettingRepository;

    public function __construct(CalculatorSettingRepository $calculatorSettingRepository)
    {
        $this->calculatorSettingRepository = $calculatorSettingRepository;
    }
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'procedure_type' => 'required|in:' . implode(',', $this->calculatorSettingRepository->getProcedureTypes()),
            'court_level' => 'required|in:' . implode(',', $this->calculatorSettingRepository->getCourtLevels()),
            'amount' => 'required|numeric|min:0',
            'real_estate' => 'nullable|boolean',
            'pre_evidence' => 'nullable|boolean',
            'fmh' => 'nullable|boolean',
            'discounts' => 'nullable|boolean',
            'indefinable' => 'nullable|boolean',
            'special_type' => 'nullable|in:' . implode(',', $this->calculatorSettingRepository->getSpecialCaseTypes()),
        ];
    }
}
