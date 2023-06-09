<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer("position")->require();
            $table->string("icon_class",30)->nullable();
            $table->string("name",30)->require()->unique();
            $table->string("original_name",30)->nullable();
            $table->integer('parent_menu_id')->nullable();
            $table->boolean('is_active')->default(true)->require();
            $table->integer('module_id')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
