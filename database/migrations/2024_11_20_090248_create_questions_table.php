<?php

use App\Models\Question;
use App\Models\Survey;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('left_statement');
            $table->string('right_statement');
            $table->string('left_personality');
            $table->string('right_personality');
            $table->unsignedInteger('sequence')->default(0);
            $table->foreignIdFor(Survey::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->index(['survey_id', 'sequence']);
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Survey::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Question::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained();
            $table->text('answer');
            $table->timestamps();

            $table->unique(['question_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
    }
};
