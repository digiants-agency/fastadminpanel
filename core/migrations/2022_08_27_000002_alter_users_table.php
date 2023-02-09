<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasColumn('users', 'id_roles')) {

			Schema::table('users', function (Blueprint $table) {
				$table->integer('id_roles')->default(1);
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('users', 'id_roles')) {

			Schema::table('users', function (Blueprint $table) {
				$table->dropColumn('id_roles');
			});
		}
	}
};
