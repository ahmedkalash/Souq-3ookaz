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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('has_special_price');
            $table->enum('special_price_type',['fixed', 'percentage'])->nullable();
            $table->decimal('special_price')->nullable();
            $table->dateTime('when_special_price_start')->nullable();
            $table->dateTime('when_special_price_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(
                'has_special_price',
                'special_price_type',
                'special_price',
                'when_special_price_start',
                'when_special_price_end',
            );
        });
    }
};
