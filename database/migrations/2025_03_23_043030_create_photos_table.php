<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('slug')->nullable();
            $table->json('alternative_slugs')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('promoted_at')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('color')->nullable();
            $table->string('blur_hash')->nullable();
            $table->text('description')->nullable();
            $table->string('alt_description')->nullable();
            $table->json('urls')->nullable();
            $table->json('links')->nullable();
            $table->integer('likes')->nullable();
            $table->boolean('liked_by_user')->nullable();
            $table->json('current_user_collections')->nullable();
            $table->json('sponsorship')->nullable();
            $table->json('topic_submissions')->nullable();
            $table->string('asset_type')->nullable();
            $table->json('user')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('photos');
    }
};
