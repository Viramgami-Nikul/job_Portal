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
        Schema::table('jobs', function (Blueprint $table) {
            
            //default(1) yani  ki dropdown me hame categories dikhani hai

            //here use the foreign id of user_id vo jab job create hoga tab user_id belong karega 
            $table->foreignId('user_id')->after('job_type_id')->constrained()->onDelete('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
         
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
            
        });
    }
};
