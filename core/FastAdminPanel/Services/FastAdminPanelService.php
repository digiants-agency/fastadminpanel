<?php 

namespace App\FastAdminPanel\Services;

use Illuminate\Http\Request;

class FastAdminPanelService
{
	public function isSingleSaving(Request $request)
	{
		// $request->query('accountId');
	}

	public function isAdminPanel(Request $request)
	{
		return $request->is(config('fap.panel_url') . '/*') || $request->is(config('fap.panel_url'));
	}
}