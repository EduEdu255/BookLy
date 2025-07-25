<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->renameColumn('external_id)', 'external_id');
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->renameColumn('external_id', 'external_id)');
        });
    }
};
