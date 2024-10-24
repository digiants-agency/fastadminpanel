<?php

namespace App\FastAdminPanel\Services\Single;

use App\FastAdminPanel\Models\SingleBlock;
use App\FastAdminPanel\Models\SingleField;

class SingleSetService
{
	public function set($blocks, $pageId)
	{
		// for auth
		$blockIds = SingleBlock::where('single_page_id', $pageId)
		->get()
		->pluck('id');

		// TODO: reduce number of requests to DB
		foreach ($blocks as $block) {

			foreach ($block['fields'] as $field) {

				$singleField = SingleField::whereIn('single_block_id', $blockIds) // $blockIds for auth
				->where('id', $field['id'])
				->first();

				if ($field['type'] != 'repeat') {

					$singleField->value = $singleField->encodeValue($field['value'] ?? null);

				} else {

					$this->repeat($field['value']['fields'], $blockIds);

					$singleField->value = $singleField->encodeValue($field['value']['length']);
				}

				$singleField->multilanguageSave();
			}			
		}
	}

	protected function repeat($fields, $blockIds)
	{
		foreach ($fields as $field) {

			$singleField = SingleField::whereIn('single_block_id', $blockIds) // $blockIds for auth
			->where('id', $field['id'])
			->first();

			if ($field['type'] != 'repeat') {

				$func = function ($item) use (&$func, $singleField) {
					return is_array($item) ? array_map($func, $item) : $singleField->encodeValue($item);
				};

				$formatted = array_map($func, $field['value']);
				
				$singleField->value = json_encode($formatted, JSON_UNESCAPED_UNICODE);

			} else {

				$this->repeat($field['value']['fields'], $blockIds);

				$singleField->value = $singleField->encodeValue($field['value']['length']);
			}

			$singleField->multilanguageSave();
		}
	}
}
