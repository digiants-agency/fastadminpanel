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
		Schema::create('single_pages', function (Blueprint $table) {
			$table->id();
			$table->string("title")->default("");
			$table->integer("sort")->default(0);
			$table->integer('parent')->default(0);

			$table->index("title");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('single_pages');
	}
};
