<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRecipientUpdateName extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipient', function (Blueprint $table) {
			$table->renameColumn('name', 'name_first');
			$table->string('name_last')->nullable();
			$table->string('email')->nullable();
			$table->uuid('org_id')->nullable();
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
			$table->dropColumn('name_last');
			$table->renameColumn('name_first', 'name');
			$table->dropColumn('email');
			$table->dropColumn('org_id');
		});
	}
}
