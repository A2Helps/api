<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancledToDonation extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('donation', function (Blueprint $table) {
			$table->boolean('canceled')->default(false);
			$table->timestamp('canceled_at')->nullable();

			$table->boolean('completed')->default(false);
			$table->timestamp('completed_at')->nullable();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::table('donation', function (Blueprint $table) {
			$table->dropColumn('canceled_at');
			$table->dropColumn('canceled');

			$table->dropColumn('completed_at');
			$table->dropColumn('completed');
		});
	}
}
