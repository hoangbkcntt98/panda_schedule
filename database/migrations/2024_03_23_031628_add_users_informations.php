<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $name = 'users';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->name, function (Blueprint $table) {
            $table->text('learning_goals')->nullable()->after('password');
            $table->tinyInteger('proficiency_level')->default(1)->after('password');
            $table->integer('account_level')->default(1)->after('password');
            $table->tinyInteger('status')->default(1)->after('password');
            $table->text('avatar')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->name, function (Blueprint $table) {
            $table->dropColumn('learning_goals');
            $table->dropColumn('proficiency_level');
            $table->dropColumn('account_level');
            $table->dropColumn('status');
            $table->dropColumn('avatar');
        });
    }
};
