<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('table_name');
			$table->text('fields');
			$table->integer('is_dev');
			$table->integer('multilanguage');
			$table->integer('is_soft_delete');
			$table->integer('sort');
			$table->integer('parent')->default(0);
			$table->string('icon')->default('')->nullable();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		});

		DB::table('menu')->insert([
			'title'             => 'Menu',
			'table_name'        => 'menu',
			'fields'            => '[]',
			'is_dev'            => '1',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '0',
		]);

		DB::table('menu')->insert([
			'title'             => 'Roles',
			'table_name'        => 'roles',
			'fields'            => '[{"id":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"title","title":"Title"}]',
			'is_dev'            => '1',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '1',
		]);

		DB::table('menu')->insert([
			'title'             => 'Users',
			'table_name'        => 'users',
			'fields'            => '[{"id":0,"lang":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"name","title":"Name"},{"id":1,"required":"optional","is_visible":true,"lang":1,"show_in_list":"no","type":"relationship","relationship_count":"single","relationship_table_name":"roles","title":"Role","relationship_view_field":"title"},{"id":2,"lang":0,"required":"optional","is_visible":true,"show_in_list":"yes","type":"text","db_title":"email","title":"Email"},{"id":3,"lang":0,"required":"optional","is_visible":true,"show_in_list":"no","type":"password","db_title":"password","title":"Password"}]',
			'is_dev'            => '0',
			'multilanguage'     => '0',
			'is_soft_delete'    => '0',
			'sort'              => '2',
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('menu');
	}
};
