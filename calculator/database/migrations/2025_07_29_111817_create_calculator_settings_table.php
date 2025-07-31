<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('calculator_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_label')->unique();
            $table->string('setting_key')->unique();
            $table->json('setting_value');
         });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculator_settings');
    }
};
