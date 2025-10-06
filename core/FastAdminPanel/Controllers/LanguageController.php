<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Language;
use App\FastAdminPanel\Requests\Language\StoreRequest;
use App\FastAdminPanel\Requests\Language\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class LanguageController extends Controller
{
    public function index()
    {
        return Language::get();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        Language::create([
            'tag' => $data['tag'],
            'main_lang' => 0,
        ]);

        return Response::json();
    }

    public function update(UpdateRequest $request, Language $language)
    {
        Language::where('id', '!=', 0)
            ->update([
                'main_lang' => 0,
            ]);

        $language->main_lang = 1;
        $language->save();

        return Response::json();
    }

    public function destroy(Language $language)
    {
        if ($language->main_lang == 1) {

            return Response::json(['message' => 'Cant delete the main language'], 422);
        }

        $language->delete();

        return Response::json();
    }
}
