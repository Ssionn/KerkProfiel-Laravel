<?php

use App\Models\Team;
use App\Models\User;
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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['DRAFT', 'PUBLISHED', 'CLOSED'])->default('draft');
            $table->unsignedBigInteger('amount_of_questions')->default(0);
            $table->foreignIdFor(Team::class, 'team_id')->nullable();
            $table->foreignIdFor(User::class, 'creator_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
