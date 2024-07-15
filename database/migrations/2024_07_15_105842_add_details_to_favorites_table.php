<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToFavoritesTable extends Migration
{
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropColumn(['title', 'author', 'price', 'rating']);
        });
    }
}
