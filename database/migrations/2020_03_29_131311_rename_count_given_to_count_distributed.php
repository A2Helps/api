<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCountGivenToCountDistributed extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('org', function (Blueprint $table) {
			$table->renameColumn('count_given', 'count_distributed');
		});

		Schema::table('org_member', function (Blueprint $table) {
			$table->renameColumn('count_given', 'count_distributed');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::table('org_member', function (Blueprint $table) {
			$table->renameColumn('count_distributed', 'count_given');
		});

		Schema::table('org', function (Blueprint $table) {
			$table->renameColumn('count_distributed', 'count_given');
		});
	}
}
