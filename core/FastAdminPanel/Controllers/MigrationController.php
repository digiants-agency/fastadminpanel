<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Menu;
use App\FastAdminPanel\Requests\CreateTableRequest;
use App\FastAdminPanel\Requests\RemoveTableRequest;
use App\FastAdminPanel\Requests\UpdateTableRequest;
use App\FastAdminPanel\Services\TableService;
use App\FastAdminPanel\Responses\JsonResponse;
use App\FastAdminPanel\Services\MigrationService;
use App\FastAdminPanel\Services\ModelService;

class MigrationController extends \App\Http\Controllers\Controller
{
	private $tableService;
	private $migrationService;
	private $modelService;

	public function __construct(TableService $tableService, MigrationService $migrationService, ModelService $modelService)
	{
		$this->tableService = $tableService;
		$this->migrationService = $migrationService;
		$this->modelService = $modelService;
	}

	public function createTable(CreateTableRequest $r)
	{
		$data = $r->validated();

		$data['model'] = $this->modelService->create($data);

		$tables = $this->tableService->getTables($data['table_name'], $data['multilanguage']);

		foreach ($tables as $table) {
			$this->migrationService->create($table, $data);
		}

		Menu::create($data);

		return JsonResponse::response();
	}

	public function removeTable(RemoveTableRequest $r)
	{
		$data = $r->validated();

		$tables = $this->tableService->getTables($data['table_name']);

		$this->modelService->delete($data);

		foreach ($tables as $table) {
			$this->migrationService->delete($table);
		}

		Menu::where('table_name', $data['table_name'])
		->delete();

		return JsonResponse::response();
	}

	public function updateTable(UpdateTableRequest $r)
	{
		$data = $r->validated();

		$this->modelService->update($data);

		$tables = $this->tableService->getTables($data['table_name']);

		foreach ($tables as $table) {
			$this->migrationService->update($table, $data);
		}

		unset($data['id']);
		unset($data['to_remove']);
		
		Menu::where('table_name', $data['table_name'])
		->update($data);

		return JsonResponse::response();
	}
}