<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Requests\Single\DestroyRequest;
use App\FastAdminPanel\Requests\Single\UpdateRequest;
use App\FastAdminPanel\Single\SingleSaver;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SingleController extends Controller
{
    public function update(UpdateRequest $request, SingleSaver $saver)
    {
        $data = $request->validated();

        $saver->setPage($data);
        $saver->save($data['blocks']);

        return Response::json();
    }

    public function destroy(DestroyRequest $request, SingleSaver $saver)
    {
        $data = $request->validated();

        $saver->setPage($data);
        $saver->remove();

        return Response::json();
    }
}
