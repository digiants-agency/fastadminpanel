<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\FastAdminPanel\Models\Language;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$languages = Language::get();

		foreach ($languages as $lang) {

			if (!Schema::hasTable("single_fields_{$lang->tag}")) {

				Schema::create("single_fields_{$lang->tag}", function (Blueprint $table) {
					$table->id();
					$table->tinyInteger("is_multilanguage")->default(0);
					$table->string("type")->default('text');
					$table->string("title");
					$table->string("slug");
					$table->integer("single_block_id");
					$table->integer("sort")->default(0);
					$table->integer("parent_id")->default(0);
					$table->text("value")->default('');

					$table->index("single_block_id");
					$table->index("parent_id");
					$table->index("slug");
				});
			}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$languages = Language::get();

		foreach ($languages as $lang) {
			
			Schema::dropIfExists("single_fields_{$lang->tag}");
		}
	}
};
