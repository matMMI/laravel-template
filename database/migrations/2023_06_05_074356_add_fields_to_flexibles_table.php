<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('flexibles', function (Blueprint $table) {
            $table->date('date_verification')->nullable();
            $table->string('status')->nullable();
            $table->string('etat')->nullable();
            $table->string('controlleur')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flexibles', function (Blueprint $table) {
            //
        });
    }
};