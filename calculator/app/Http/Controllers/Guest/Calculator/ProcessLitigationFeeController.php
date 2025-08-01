<?php

namespace App\Http\Controllers\Guest\Calculator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessLitigationFeeRequest;

class ProcessLitigationFeeController extends Controller
{
    public function handle(ProcessLitigationFeeRequest $request)
    {
        $validated =$request->validated();

        
    }
}
