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

	public function isSingleSaving()
	{
		return !is_null($this->request->query('update')) && config('app.debug');
	}

	public function isAdminPanel()
	{
		return $this->request->is(config('fap.panel_url') . '/*') || $this->request->is(config('fap.panel_url'));
	}
}