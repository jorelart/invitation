<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('invitation_photos')->insertOrIgnore([
            'slot' => 'opening',
            'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_AKHIR-e1761191657903.jpg',
            'caption' => 'Foto halaman pembuka',
            'sort_order' => 0,
            'width' => 875,
            'height' => 1130,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Keep the opening photo and administrator changes when rolling back.
    }
};
