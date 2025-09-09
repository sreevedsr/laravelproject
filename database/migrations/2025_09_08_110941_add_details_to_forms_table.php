<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('forms', function (Blueprint $table) {
        $table->string('first_name');
        $table->string('last_name');
        $table->string('phone')->nullable();
    });
}

public function down()
{
    Schema::table('forms', function (Blueprint $table) {
        $table->dropColumn(['first_name', 'last_name', 'phone']);
    });
}

};
