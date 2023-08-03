<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("prefix");
            $table->date("current_date")->nullable();
            $table->bigInteger("starting_value");
            $table->integer("max_digit");
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
