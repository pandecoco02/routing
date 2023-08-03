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
            $table->unsignedBiginteger('Applicant_id') ->nullable();
            $table->string('CommunityTaxNumber') ->nullable();
            $table->string('CommunityTaxFee') ->nullable();
            $table->string('CommunityTaxDatePaid') ->nullable();
            $table->string('MayorsPermitNumber') ->nullable();
            $table->string('MayorsPermitFee') ->nullable();
            $table->string('MayorsPermitDatePaid') ->nullable();
            $table->string('HealthCardNumber') ->nullable();
            $table->string('PoliceClearanceNo') ->nullable();
            $table->string('PoliceClearanceExpiryDate') ->nullable();
            $table->timestamp('DateIssued') ->nullable();
            $table->string('DateHired') ->nullable();
            $table->string('EmploymentTypeID') ->nullable();
            $table->string('Status') ->nullable();
            $table->timestamps();
            $table->foreign('Applicant_id') -> references('id') -> on('applicants')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('occupational_permits');
    }
};
