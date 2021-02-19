<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIvaToProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal("iva", 5, 2)->nullable();
        });
        Schema::table('productos_vendidos', function (Blueprint $table) {
            $table->decimal("iva", 5, 2)->nullable();
        });
        DB::statement("UPDATE productos SET iva = 21.00");
        DB::statement("UPDATE productos_vendidos SET iva = 21.00");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['iva']);
        });
    }
}
