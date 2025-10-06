<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Requests\Image\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $userId = Auth::id();

        $uploadPath = "photos/$userId/";

        $img = $request->file('upload');

        if ($img != null) {

            $imgName = time().'-'.$img->getClientOriginalName();
            $img->move($uploadPath, $imgName);

            return Response::json(['url' => "/{$uploadPath}{$imgName}"]);
        }

        return Response::json([], 418);
    }
}
