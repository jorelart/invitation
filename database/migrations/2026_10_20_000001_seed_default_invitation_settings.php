<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('invitation_settings')->insertOrIgnore([
            'key' => 'home',
            'value' => json_encode(config('invitation'), JSON_THROW_ON_ERROR),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Keep any settings edited by an administrator if this seed migration is rolled back.
    }
};
