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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string("symbol");
            $table->string("name");
            $table->string("symbol_native");
            $table->integer("decimal_digits");
            $table->string("code")->unique();
            $table->string("name_plural");
            $table->decimal('exchange_rate_from_base',16,8);
            $table->dateTime('exchange_rate_from_base_last_updated_at');
            $table->enum("type", ['fiat', 'metal', 'crypto']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};







