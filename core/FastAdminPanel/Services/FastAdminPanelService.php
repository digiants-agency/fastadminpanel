<?php

namespace App\FastAdminPanel\Services;

use Illuminate\Http\Request;

class FastAdminPanelService
{
    public function __construct(
        protected Request $request,
    ) {}

    public function isAdminPanel()
    {
        // it is incorrect
        // return $this->request->is(config('fastadminpanel.panel_url') . '/*') || $this->request->is(config('fastadminpanel.panel_url'));
    }
}
