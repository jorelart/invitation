<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('invitation_photos')
            ->where('slot', 'bride')
            ->where('path', 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL_.jpg')
            ->update(['path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL.jpg']);

        DB::table('invitation_photos')
            ->where('slot', 'groom')
            ->where('path', 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL.jpg')
            ->update(['path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL_.jpg']);
    }

    public function down(): void
    {
        DB::table('invitation_photos')
            ->where('slot', 'bride')
            ->where('path', 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL.jpg')
            ->update(['path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL_.jpg']);

        DB::table('invitation_photos')
            ->where('slot', 'groom')
            ->where('path', 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL_.jpg')
            ->update(['path' => 'assets/vendor/site/wp-content/uploads/2026/06/25KN154_PROFIL.jpg']);
    }
};
