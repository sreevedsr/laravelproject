<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('forms', function (Blueprint $table) {
        $table->unsignedBigInteger('designation_id')->nullable()->after('phone');

        // Add foreign key constraint if needed
        $table->foreign('designation_id')->references('id')->on('designations')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('forms', function (Blueprint $table) {
        $table->dropForeign(['designation_id']);
        $table->dropColumn('designation_id');
    });
}

};
