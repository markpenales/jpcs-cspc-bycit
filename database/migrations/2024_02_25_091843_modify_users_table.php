<?php

use App\Models\College;
use App\Models\Section;
use App\Models\TShirtSize;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(College::class);
            $table->foreignIdFor(Section::class);
            $table->foreignIdFor(TShirtSize::class);
            $table->string('nickname')->nullable();
            $table->string('dietary_restrictions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
