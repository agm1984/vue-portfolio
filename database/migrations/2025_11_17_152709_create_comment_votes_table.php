<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentVotesTable extends Migration
{
    public function up()
    {
        Schema::create('comment_votes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('comment_id')
                ->constrained('comments')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // +1 for thumbs up, -1 for thumbs down
            $table->tinyInteger('value');

            $table->timestamps();

            // One vote per user per comment
            $table->unique(['comment_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comment_votes');
    }
}
