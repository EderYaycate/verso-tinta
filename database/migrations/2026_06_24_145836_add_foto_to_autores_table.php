<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoToAutoresTable extends Migration
{
    public function up()
    {
        Schema::table('autores', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('nacionalidad');
        });
    }

    public function down()
    {
        Schema::table('autores', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
}