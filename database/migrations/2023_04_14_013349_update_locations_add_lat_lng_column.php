<?php

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
        //
        Schema::table('locations', function($table) {
            $table->double('lat');
            $table->double('lng');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('locations', function($table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
    }
};
