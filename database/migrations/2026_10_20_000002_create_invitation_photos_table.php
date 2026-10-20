<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_photos', function (Blueprint $table): void {
            $table->id();
            $table->string('slot', 32)->index();
            $table->string('path', 500);
            $table->string('caption')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->timestamps();
            $table->unique(['slot', 'path']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_photos');
    }
};
