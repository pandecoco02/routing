<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('occupational_permits', function (Blueprint $table) {
            $table->id('OccupationalPermit_id')->unique();
            $table->string('CommunityTaxNumber');
            $table->double('CommunityTaxFee');
            $table->dateTime('CommunityTaxDatePaid');
            $table->string('MayorsPermitNumber');
            $table->double('MayorsPermitFee');
            $table->dateTime('MayorsPermitDatePaid');
             $table->string('HealthCardNumber');
             $table->string('PoliceClearanceNo');
             $table->string('PoliceClearanceExpiryDate');
             $table->timestamp('DateIssued');
             $table->string('PermitNo');
             $table->dateTime('DateHired');
            
             $table->string('ApplicantID');
             $table->string('SignatoryID');
             $table->string('EmploymentTypeID');
             $table->string('Status');
            $table->timestamps();
            $table->foreign('OccupationalPermit_id') -> references('id') -> on('applicants')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('occupational_permits');
    }
};
