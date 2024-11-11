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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('address_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('paternal_name');
            $table->string('street');
            $table->string('house_number');
            $table->string('apartment_number');
            $table->string('country');
            $table->string('region');
            $table->string('city');
            $table->string('phone');
            $table->string('id_number');
            $table->integer('pinfl');
            $table->string('extra_info')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
