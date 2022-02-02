<?php

namespace Digiants\FastAdminPanel\ShopTemplates;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\FastAdminPanel\Helpers\Lang;

class ShopTemplateDTG extends ShopTemplate{

    private function shop_path_package ($path) {

		return base_path("/vendor/sv-digiants/fastadminpanel/templates/shop/DTG" . $path);
	}

    public function import_shop(){

        $this->import_public();
		$this->import_routes();
		$this->import_app();
		$this->import_resources();

		$this->import_db();

        return 'Success';
	}

	private function import_public(){
		$this->copy_folder($this->shop_path_package("/public/"), public_path());
	}

	private function import_routes(){
		$this->copy_folder($this->shop_path_package("/routes/"), base_path("/routes/"));
	}

	private function import_app(){
		$this->copy_folder($this->shop_path_package("/app/"), base_path("/app/"));
	}

	private function import_resources(){
		$this->copy_folder($this->shop_path_package("/resources/"), base_path("/resources/"));
	}

	private function import_db(){

		$langs_new = DB::table('languages')
		->get()
		->pluck('tag')
		->all();

		$sql = file_get_contents($this->shop_path_package("/db.sql"));

		DB::unprepared($sql);

		$langs_old = DB::table('languages')
		->get()
		->pluck('tag')
		->all();

		foreach ($langs_new as $lang_new) {

			if (!in_array($lang_new, $langs_old)) {
				Lang::add($lang_new);
			}
		}

		foreach ($langs_old as $lang_old){

			if (!in_array($lang_old, $langs_new)) {
				Lang::remove($lang_old);
			}
		}

	}

}