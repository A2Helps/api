<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropNotNullFromUserEmail extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user', function (Blueprint $table) {
			DB::statement('alter table public.user alter column email drop not null');
			DB::statement('alter table public.user alter column name_first drop not null');
			DB::statement('alter table public.user alter column name_last drop not null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user', function (Blueprint $table) {
			DB::statement('alter table public.user alter column email set not null');
			DB::statement('alter table public.user alter column name_last set not null');
			DB::statement('alter table public.user alter column name_first set not null');
		});
	}
}
