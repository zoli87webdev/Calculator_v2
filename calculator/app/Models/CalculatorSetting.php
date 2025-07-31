<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorSetting extends Model
{
    protected $fillable = [
        'setting_label',
        'setting_key',
        'setting_value',

    ];

    protected $casts = [
        'setting_value' => 'array',
    ];

    public $timestamps = false;

}
