<?php

namespace App\FastAdminPanel\Observers;

use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Services\Crud\MigrationService;
use App\FastAdminPanel\Services\Crud\ModelService;

class CrudObserver
{
    public function __construct(
        protected MigrationService $migrationService,
        protected ModelService $modelService,
    ) {}

    public function created(Crud $crud): void
    {
        $crud->model = $this->modelService->create($crud);
        $crud->save();
        $this->migrationService->create($crud);
    }

    public function updated(Crud $crud): void
    {
        $this->modelService->update($crud);
        $this->migrationService->update($crud);
    }

    public function deleted(Crud $crud): void
    {
        $this->modelService->delete($crud);
        $this->migrationService->delete($crud);
    }

    public function restored(Crud $crud): void
    {
        //
    }

    public function forceDeleted(Crud $crud): void
    {
        //
    }
}
