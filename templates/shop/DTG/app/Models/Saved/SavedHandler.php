<?php

namespace App\Models\Saved;

use Illuminate\Database\Eloquent\Model;

class SavedHandler extends Saved {

	public function __construct () {
		parent::__construct('saved', 'products');
	}
}