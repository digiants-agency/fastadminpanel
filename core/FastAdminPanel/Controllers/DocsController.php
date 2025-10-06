<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Services\Docs\CrudService;
use App\FastAdminPanel\Services\Docs\SingleService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class DocsController extends Controller
{
    public function __construct(
        protected CrudService $crudService,
        protected SingleService $singleService,
    ) {}

    public function index()
    {
        $docs = collect([]);

        $docs = $docs->merge($this->crudService->get());
        $docs = $docs->merge($this->singleService->get());

        $docs['Example'] = [
            [
                'method' => 'PUT',
                'endpoint' => '/api/example/{id}/value/{slug}',
                'description' => 'It is just the example. You can change docs in App/FastAdminPanel/Controllers/DocsController.php',
                'fields' => [
                    [
                        'title' => 'title',
                        'required' => 'required',
                        'type' => 'String',
                        'desc' => 'max: 191',
                    ],
                    [
                        'title' => 'is_dev',
                        'required' => 'nullable',
                        'type' => 'Integer',
                        'desc' => 'between:0,1',
                    ],
                ],
            ],
        ];

        return Response::json([
            'docs' => $docs,
        ]);
    }
}
