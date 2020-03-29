<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintedToRecipient extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('recipient', function (Blueprint $table) {
			$table->boolean('printed')->default(false);
			$table->timestamp('printed_at')->nullable();

			$table->boolean('distributed')->default(false);
			$table->timestamp('distributed_at')->nullable();
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
			$table->dropColumn('distributed_at');
			$table->dropColumn('distributed');

			$table->dropColumn('printed_at');
			$table->dropColumn('printed');
		});
	}
}
