<?php 

namespace App\FastAdminPanel\Services;

use Illuminate\Http\Request;

class FastAdminPanelService
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function isAdminPanel()
	{
		return $this->request->is(config('fastadminpanel.panel_url') . '/*') || $this->request->is(config('fastadminpanel.panel_url'));
	}
}