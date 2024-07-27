<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Services\FilesService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SpaController extends Controller
{
	public function spa(FilesService $filesService)
	{
		$user = Auth::user();

		App::setLocale($user->admin_lang_tag ?? 'en');

		$customFields = $filesService->getFilesFromResources('/views/fastadminpanel/pages/admin/fields/custom');

		return view('fastadminpanel.layouts.app')->with([
			'customFields'		=> $customFields,
			'hiddenMenuParam'	=> config('fap.hidden_menu_query'),
		]);
	}
}