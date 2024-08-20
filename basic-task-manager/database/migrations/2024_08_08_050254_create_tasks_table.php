<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('modified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('modified_at')->nullable();
        });

        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');  
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('labels');
    }
};
