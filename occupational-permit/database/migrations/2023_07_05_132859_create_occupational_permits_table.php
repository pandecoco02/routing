<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('occupational_permits', function (Blueprint $table) {
            $table->bigIncrements("permit_id") ;
            $table->unsignedBiginteger('Applicant_id');
            $table->string('CommunityTaxNumber');
            $table->string('CommunityTaxFee');
            $table->string('CommunityTaxDatePaid');
            $table->string('MayorsPermitNumber');
            $table->string('MayorsPermitFee');
            $table->string('MayorsPermitDatePaid');
             $table->string('HealthCardNumber');
             $table->string('PoliceClearanceNo');
             $table->string('PoliceClearanceExpiryDate');
             $table->timestamp('DateIssued');
             
             $table->string('DateHired');
             $table->string('SignatoryID');
             $table->string('EmploymentTypeID');
             $table->string('Status');
            $table->timestamps();
            $table->foreign('Applicant_id') -> references('id') -> on('applicants')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('occupational_permits');
    }
};
