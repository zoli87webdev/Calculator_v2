<?php

namespace App\Http\Controllers\Guest\Calculator;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Services\LitigationFeeService;

class ShowLitigationFeeController extends Controller
{
    private LitigationFeeService $litigationFeeService;

    public function __construct(LitigationFeeService $litigationFeeService)
    {
        $this->litigationFeeService = $litigationFeeService;
    }

    public function index(): View
    {
        $settings = $this->litigationFeeService->handle();

        return view("guest.calculators.litigation-fee", compact('settings') );
    }

}
