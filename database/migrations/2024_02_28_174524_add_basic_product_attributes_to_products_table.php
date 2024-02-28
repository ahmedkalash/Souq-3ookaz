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
            $table->string('type');
            $table->string('sku');
            $table->dateTime('mfg')
                ->default('1000-10-10 10:10:10');
            $table->integer('stock');
        });

        DB::transaction(function (){
            $range = DB::table('products')->count() * 100;
            DB::table('products')->update([
                'sku' =>  DB::raw("FLOOR(1 + RAND() * $range)")
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')
                ->unique()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('sku');
            $table->dropColumn('mfg');
            $table->dropColumn('stock');
        });
    }
};
