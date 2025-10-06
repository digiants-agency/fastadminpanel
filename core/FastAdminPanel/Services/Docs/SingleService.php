<?php

namespace App\FastAdminPanel\Services\Docs;

use App\FastAdminPanel\Models\SinglePage;

class SingleService
{
    public function get()
    {
        $pages = SinglePage::get();

        $docs = collect([]);

        $singles = $pages->map(fn ($p) => [
            'method' => 'GET',
            'endpoint' => "/fapi/singles/{$p->slug}",
            'description' => "Get all phrases from part: '{$p->title}'",
            'fields' => [],
        ]);

        if ($singles->count()) {

            $docs['Static parts'] = $singles;
        }

        return $docs;
    }
}
