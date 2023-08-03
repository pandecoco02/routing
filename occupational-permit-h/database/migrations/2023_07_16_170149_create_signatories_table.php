<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('signatories', function (Blueprint $table) {
            $table->bigIncrements("id")->unique();
            $table->string('LastName');
            $table->string('FirstName');
            $table->string('MiddleName') ->nullable();
            $table->string('ExtensionName') ->nullable();
            $table->string('Position');
            $table->string('DivisionName');
            $table->string('OfficeName');
            $table->string('City');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signatories');
    }
};
