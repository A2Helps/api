<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentToRecipient extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('recipient', function (Blueprint $table) {
			$table->boolean('sent')->default(false);
			$table->timestamp('sent_at')->nullable();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::table('recipient', function (Blueprint $table) {
			$table->dropColumn('sent_at');
			$table->dropColumn('sent');
		});
	}
}
