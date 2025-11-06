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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->nullable()->unique();
            $table->string("phone")->nullable();
            $table->date("dob")->nullable();
            $table->string("address")->nullable();
            $table->string("complement")->nullable();
            $table->string("neighbor")->nullable();
            $table->string("postal_code")->nullable();
            $table->string("sign_date")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
