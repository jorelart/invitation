<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            ['slot' => 'bride', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL.jpg', 'caption' => 'Foto mempelai wanita', 'sort_order' => 0, 'width' => 1024, 'height' => 1535],
            ['slot' => 'groom', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL_.jpg', 'caption' => 'Foto mempelai pria', 'sort_order' => 0, 'width' => 1024, 'height' => 1535],
            ['slot' => 'story', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_AWAL-Copy-e1761191408395.jpg', 'caption' => 'Foto cerita pasangan', 'sort_order' => 0, 'width' => 1023, 'height' => 1023],
            ['slot' => 'closing', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_AKHIR-e1761191657903.jpg', 'caption' => 'Foto penutup', 'sort_order' => 0, 'width' => 875, 'height' => 1130],
            ['slot' => 'gallery', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_2-3-e1761191599275.jpg', 'caption' => 'Galeri 1', 'sort_order' => 1, 'width' => 885, 'height' => 1535],
            ['slot' => 'gallery', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_1-1.jpg', 'caption' => 'Galeri 2', 'sort_order' => 2, 'width' => 1024, 'height' => 1535],
            ['slot' => 'gallery', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_1-2.jpg', 'caption' => 'Galeri 3', 'sort_order' => 3, 'width' => 1024, 'height' => 1535],
            ['slot' => 'gallery', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_1-3.jpg', 'caption' => 'Galeri 4', 'sort_order' => 4, 'width' => 1024, 'height' => 1535],
            ['slot' => 'gallery', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_2-1.jpg', 'caption' => 'Galeri 5', 'sort_order' => 5, 'width' => 1024, 'height' => 1535],
            ['slot' => 'gallery', 'path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_2-2.jpg', 'caption' => 'Galeri 6', 'sort_order' => 6, 'width' => 1024, 'height' => 1535],
        ];

        foreach ($defaults as $photo) {
            DB::table('invitation_photos')->insertOrIgnore([
                ...$photo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Preserve photos and administrator changes when rolling back the default-data migration.
    }
};
