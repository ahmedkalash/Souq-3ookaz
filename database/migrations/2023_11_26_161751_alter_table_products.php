<?php

use App\Models\Product;
use App\Models\User;
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
        Schema::table(Product::tableName(), function (Blueprint $table) {
            $table->longText('description')->nullable();
            $table->text('brand');
            $table->string('owner_type');
            $table->string('slug')->index();
            $table->decimal('price', unsigned:true);
            $table->foreignId('owner_id')->constrained(User::tableName())->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Product::tableName(), function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('brand');
            $table->dropColumn('owner_type');
            $table->dropConstrainedForeignId('owner_id') ;
            $table->dropColumn('slug');
            $table->dropColumn('price' );
        });
    }
};
