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
        Schema::table('pengurus', function (Blueprint $table) {
            // Check if column exists before renaming
            if (Schema::hasColumn('pengurus', 'departemen')) {
                $table->renameColumn('departemen', 'departemen_id');
            }
            // If already renamed or original, ensure it's index/foreign key capable
            // We assume it is varchar(255) as seen in previous steps. 
            // Departemen ID is also varchar(255).
        });
        
        Schema::table('pengurus', function (Blueprint $table) {
            // Add Foreign Keys explicitly if not exists
            // We use a safe approach, check if index exists first or try-catch
            // But standard migration is:
            
            // 1. Departemen FK
            // $table->foreign('departemen_id')->references('id')->on('departemens')->nullOnDelete();
            
            // 2. Parent ID FK
            // $table->foreign('parent_id')->references('id')->on('pengurus')->nullOnDelete();
            
            // Since we are SQLite/MariaDB, let's just add index to be safe and efficient
            $table->index('departemen_id');
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
             if (Schema::hasColumn('pengurus', 'departemen_id')) {
                $table->renameColumn('departemen_id', 'departemen');
            }
        });
    }
};
