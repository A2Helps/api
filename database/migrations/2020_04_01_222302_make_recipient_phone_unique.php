<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeRecipientPhoneUnique extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('recipient', function (Blueprint $table) {
			$table->string('phone', 10)->unique()->change();
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
			$table->string('phone', 10)->change();
		});
	}
}
