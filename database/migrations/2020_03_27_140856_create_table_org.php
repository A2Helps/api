<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableOrg extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('org', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->string('name');

			$table->integer('allotment')->default(0);
			$table->integer('count_given')->defualt(0);
			$table->boolean('enabled')->default(false);

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});

		Schema::create('org_member', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->uuid('org_id');
			$table->uuid('user_id');

			$table->integer('allotment')->default(0);
			$table->integer('count_given')->defualt(0);
			$table->boolean('enabled')->default(false);

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
			$table->unique(['org_id', 'user_id'], 'uniq_org_user');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('org_member');
		Schema::dropIfExists('org');
	}
}
