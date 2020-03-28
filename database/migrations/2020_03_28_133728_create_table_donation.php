<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableDonation extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('donation', function (Blueprint $table) {
			$table->uuid('id')->default(DB::raw('gen_random_uuid()'));

			$table->integer('amount')->default(0);
			$table->string('email')->nullable();
			$table->string('name')->nullable();
			$table->string('co_session')->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('donation');
	}
}
