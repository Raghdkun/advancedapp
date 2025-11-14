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
        // 1) Drop FK constraint from form_submissions -> users
        Schema::table('form_submissions', function (Blueprint $table) {
            // This uses the default FK name: form_submissions_user_id_foreign
            $table->dropForeign(['user_id']);
        });

        // 2) Drop the old users table
        Schema::dropIfExists('users');

        // 3) Recreate users as projection
        Schema::create('users', function (Blueprint $table) {
            // This id comes from the auth service, not auto-incremented locally
            $table->unsignedBigInteger('id')->primary();

            $table->string('name')->nullable();
            $table->string('email')->nullable();

            // Snapshots / projection from auth service
            $table->json('roles')->nullable();
            $table->json('permissions')->nullable();

            $table->timestamps();
        });

        // 4) Re-add FK from form_submissions.user_id to users.id
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse order: drop FK, drop new users, recreate old users, re-add FK

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};
