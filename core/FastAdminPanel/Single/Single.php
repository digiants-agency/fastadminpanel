<?php 

namespace App\FastAdminPanel\Single;

use App\FastAdminPanel\Models\SinglePage;
use App\FastAdminPanel\Services\Single\SingleGetService;

class Single
{
	protected $page;
	protected $fields;
	protected $service;

	public function __construct()
	{
		$this->service = new SingleGetService();
	}

	public function get(string $slug)
	{
		$singlePageId = SinglePage::where('slug', $slug)->value('id');

		$singlePage = $this->service->get($singlePageId);
		
		return $this->formatFields($singlePage);
	}

	protected function formatFields($blocks)
	{
		$formattedBlocks = [];

		foreach ($blocks as $block) {

			$fields = [];

			foreach ($block->fields as $field) {

				if ($field->type == 'repeat') {

					$fields[$field->slug] = $this->formatRepeat($field);

				} else {

					$fields[$field->slug] = $field->value;
				}
			}

			$formattedBlocks[$block->slug] = $fields;
		}
		
		return $formattedBlocks;
	}

	protected function formatRepeat($field)
	{
		$formattedValues = [];

		foreach ($field['value']['fields'] as $repeatedField) {
			
			$formattedRepeat = $repeatedField['type'] == 'repeat' ? $this->formatRepeat($repeatedField) : [];
			
			$repeatedFieldValueIndex = 0;

			foreach ($repeatedField['value'] as $repeatedFieldValue) {

				$formattedValues[$repeatedFieldValueIndex][$repeatedField['slug']] = $repeatedField['type'] == 'repeat' ? 
					$this->transpose($formattedRepeat[$repeatedFieldValueIndex] ?? []) :
					$repeatedFieldValue;

				$repeatedFieldValueIndex += 1;
			}
		}

		return $formattedValues;
	}

	protected function transpose($array)
	{
		$result = [];
		$keys = array_keys($array);

		for ($row = 0; $row < count(reset($array)); $row++) {
			foreach ($keys as $key) {
				$result[$row][$key] = $array[$key][$row];
			}
		}

		return $result;
	}
}