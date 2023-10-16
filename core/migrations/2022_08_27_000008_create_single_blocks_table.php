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
		Schema::create('single_blocks', function (Blueprint $table) {
			$table->id();
			$table->string("title")->default("");
			$table->string("slug")->default("");
			$table->integer("sort")->default(0);
			$table->integer('single_page_id')->default(0);

			$table->index("single_page_id");
			$table->index("slug");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('single_blocks');
	}
};
