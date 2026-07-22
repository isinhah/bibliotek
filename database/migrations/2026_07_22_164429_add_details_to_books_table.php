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
        Schema::table('books', function (Blueprint $table) {
            $table->string('publisher')->nullable()->after('cover_id');
            $table->string('publish_date')->nullable()->after('publisher');
            $table->integer('pages')->nullable()->after('publish_date');
            $table->decimal('rating', 3, 2)->nullable()->after('pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['publisher', 'publish_date', 'pages', 'rating']);
        });
    }
};
