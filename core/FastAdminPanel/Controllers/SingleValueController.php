<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\SinglePage;
use App\FastAdminPanel\Policies\MainPolicy;
use App\FastAdminPanel\Services\Single\SingleGetService;
use App\FastAdminPanel\Services\Single\SingleSetService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SingleValueController extends Controller
{
	// TODO: validation
	public function index(Request $request, MainPolicy $policy)
	{
		$data = $request->all();

		$slugs = $policy->getSlugs('admin_read');

		$pages = SinglePage::when($data['is_full'], fn ($q) =>
			
			$q->with(['blocks' => fn ($q) =>
				$q->with(['fields' => fn($q) =>
					$q->with(['fields' => fn($q) =>
						$q->orderBy('sort', 'ASC')
					])
					->where('parent_id', 0)
					->orderBy('sort', 'ASC')
				])
				->orderBy('sort', 'ASC')
			])
		)
		->when(!$slugs->contains('all'), fn ($q) => $q->whereIn('slug', $slugs))
		->get();

		return Response::json($pages);
	}

	// TODO: validation
	public function show(SingleGetService $service, SinglePage $singlePage)
	{
		$this->authorize('something', [$singlePage->slug, 'admin_read']);

		$blocks = $service->get($singlePage->id);

		return Response::json($blocks);
	}
	
	// TODO: validation
	public function update(Request $request, SingleSetService $service, SinglePage $singlePage)
	{
		$this->authorize('something', [$singlePage->slug, 'admin_edit']);

		$blocks = $request->get('blocks');

		$service->set($blocks, $singlePage->id);

		return Response::json();
	}
}