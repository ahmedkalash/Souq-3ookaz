<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('product_categories','id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
         });


        DB::statement('ALTER TABLE product_categories ADD CONSTRAINT assert_name_is_json CHECK (json_valid(`name`))');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
