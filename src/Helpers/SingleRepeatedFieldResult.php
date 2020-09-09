<?php 

namespace Digiants\FastAdminPanel\Helpers;

use DB;
use App;
use Schema;
use Illuminate\Database\Schema\Blueprint;
use Lang;
use Digiants\FastAdminPanel\Helpers\SingleRepeatedField;

class SingleRepeatedFieldResult {

	protected $curr_field = 0;
	protected $curr_field_i = 0;
	protected $fields = [];

	public function __construct ($fields, $i) {

		$this->fields = $fields;
		$this->curr_field_i = $i;
	}

	public function skip_fields ($count) {
		$this->curr_field += $count;
	}

	public function field ($title, $type, $default_value = '') {

		if (isset($_GET['update']) && env('APP_DEBUG')) {

		} else {

			$value = Single::format_value(
				$this->fields[$this->curr_field]->values[$this->curr_field_i],
				$this->fields[$this->curr_field]->type
			);

			$this->curr_field++;
			// $this->curr_field_i++;

			// if (count($this->fields) == $this->curr_field_i)
			// 	$this->curr_field_i = 0;

			return $value;
		}
	}

	public function end () {

		if (isset($_GET['update']) && env('APP_DEBUG')) {

		} else {
			
		}
	}
}