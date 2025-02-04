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
        if (!Schema::hasTable('admin')) {
            Schema::create('admin', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50);
                $table->string('email', 20);
                $table->bigInteger('phone');
                $table->string('password');
                $table->integer('is_admin');
                $table->timestamps();
                $table->engine = 'MyISAM';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_general_ci';
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
