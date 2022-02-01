<?php 

namespace App;

use App\Shop\Saved;

class SavedHandler extends Saved {

	public function __construct () {
		parent::__construct('saved', 'product');
	}
}