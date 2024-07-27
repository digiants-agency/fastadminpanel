<?php

namespace App\FastAdminPanel\Models;

use App\FastAdminPanel\Models\File\JsonModel;

class RolePermission extends JsonModel
{
	public $timestamps = false;
	
	protected $table = 'role_permissions';

	protected static $fileName = 'permissions';
	
	protected static $jsonPrimaryKey = 'id';

	protected $fillable = [
		'id',
		'slug',
		'role_id',
		'admin_read',
		'admin_edit',
		'api_create',
		'api_read',
		'api_update',
		'api_delete',
		'all',
	];
}