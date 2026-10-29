<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('invitation_photos')->insertOrIgnore([
            'slot' => 'save_the_date',
            'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_AKHIR-e1761191657903.jpg',
            'caption' => 'Foto Save the Date',
            'sort_order' => 0,
            'width' => 875,
            'height' => 1130,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Preserve administrator-managed photos when rolling back.
    }
};
