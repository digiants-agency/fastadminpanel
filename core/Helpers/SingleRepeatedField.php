<?php 

namespace App\FastAdminPanel\Helpers;

use DB;
use App;
use Schema;
use Illuminate\Database\Schema\Blueprint;
use Lang;
use App\FastAdminPanel\Helpers\SingleRepeatedFieldResult;

class SingleRepeatedField {

	protected $id = 0;
	protected $is_multilanguage;
	protected $fields = [];

	public function __construct ($id, $is_multilanguage, $fields = []) {

		$this->id = $id;
		$this->is_multilanguage = $is_multilanguage;
		$this->fields = $fields;

		// if (isset($_GET['update']) && env('APP_DEBUG')) {
		// } else {

		// 	$this->fields = json_decode(
		// 		DB::table('single_text'.Lang::ending($this->is_multilanguage))
		// 		->select('value')
		// 		->where('field_id', $this->id)
		// 		->first()
		// 	);
		// }
	}

	public function field ($title, $type, $default_value = '') {

		if (isset($_GET['update']) && env('APP_DEBUG')) {

			$this->fields[] = [
				'title' 	=> $title,
				'type'		=> $type,
				'default'	=> $default_value,
				'values'	=> [],
			];

		} else {

		}
	}

	public function end () {

		if (isset($_GET['update']) && env('APP_DEBUG')) {

			$endings = [''];

			if ($this->is_multilanguage) {
				$endings = [];
				foreach (Lang::get_langs() as $lang) {
					$endings[] = '_'.$lang->tag;
				}
			}

			foreach ($endings as $ending) {

				$fields_obj = DB::table('single_text'.$ending)
				->select('value')
				->where('field_id', $this->id)
				->first();

				$fields = [1];

				if (!empty($fields_obj))
					$fields = json_decode($fields_obj->value, true);

				for ($i = 0, $count = count($this->fields); $i < $count; $i++) {
					if (empty($fields[$i]) || $fields[$i] == 1 || empty($this->fields[$i]) || $fields[$i]['title'] != $this->fields[$i]['title']) {

						DB::table('single_text'.$ending)
						->where('field_id', $this->id)
						->delete();

						DB::table('single_text'.$ending)
						->where('field_id', $this->id)
						->insert([
							'field_id'	=> $this->id,
							'value' 	=> json_encode($this->fields, JSON_UNESCAPED_UNICODE),
						]);

						break;
					}
				}
			}

		} else {
			
		}
	}

	public function get () {

		$collection = [];

		if (!empty($this->fields[0])) {
			for ($i = 0, $count = count($this->fields[0]->values); $i < $count; $i++) {
				$collection[] = new SingleRepeatedFieldResult($this->fields, $i);
			}
		}

		return $collection;
	}
}