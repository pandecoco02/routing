<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('LastName');
            $table->string('FirstName');
            $table->string('MiddleName') ->nullable();
            $table->string('ExtensionName') ->nullable();
            $table->integer('Age');
            $table->string('CivilStatus');
            $table->string('Photo') -> nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
