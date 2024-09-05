<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            'email' => 'b@gmail.com',
            'phone' => '1234555678',
            'email_verified_at' => null,
            'uid' => '23707760-0a35-11ef-a875-00ff5210c7f1',
            'is_verified' => false,
            'enabled' => false,
            'password' => '$2y$12$QYHwcqMNeQl21iN.n4HheOvWzfZVWnTE9Npf/AO7SPatPo/htFrCa',
            'connected' => true,
            'last_ip_login' => '127.0.0.1',
            'last_login' => null,
            'deleted' => false,
            'google_id' => null,
            'social_type' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'file_code' => 'uvHj4l6',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
