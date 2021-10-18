<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBiginteger('sender_id');
            $table->foreign('sender_id')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->unsignedBiginteger('reciever_id');
            $table->foreign('reciever_id')->references('id')
                  ->on('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->string('docs');
            $table->enum('type',['docs','image','pdf','text'])->default('text');       
            $table->enum('status',['read','unread'])->default('unread');
            $table->enum('seen_status',['Sent','Delivered','Seen']);
            $table->text('deleted_by')->nullable();
            $table->integer('communication_id')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('socket_id')->nullable();
            $table->enum('is_online',['yes','no'])->default('no');
            $table->unsignedBiginteger('on_chat_screen')->nullable();
            $table->foreign('on_chat_screen')->references('id')
                  ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_lists');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_online');
            $table->dropColumn('socket_id');
            $table->dropColumn('on_chat_screen');
        });
    }
}
