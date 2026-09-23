<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The 'data' table previously used idTumbuhan as its primary key,
     * which meant only ONE row per plant could ever exist — every new
     * sensor reading failed with a duplicate key error.
     *
     * This migration gives the table a proper auto-increment id so
     * every reading is stored as a new row (time-series), while
     * idTumbuhan becomes a normal indexed column.
     */
    public function up(): void
    {
        Schema::table('data', function (Blueprint $table) {
            $table->dropPrimary();
        });

        Schema::table('data', function (Blueprint $table) {
            $table->increments('id')->first();
            $table->index('idTumbuhan');
        });
    }

    public function down(): void
    {
        Schema::table('data', function (Blueprint $table) {
            $table->dropIndex(['idTumbuhan']);
            $table->dropColumn('id');
        });

        Schema::table('data', function (Blueprint $table) {
            $table->primary('idTumbuhan');
        });
    }
};
