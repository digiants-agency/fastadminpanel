<?php

namespace App\FastAdminPanel\Services\Single;

use App\FastAdminPanel\Models\SingleBlock;
use App\FastAdminPanel\Models\SingleField;

class SingleGetService
{
    public function get(int $pageId)
    {
        $blocks = SingleBlock::where('single_page_id', $pageId)
            ->orderBy('sort', 'ASC')
            ->get();

        $fields = SingleField::whereIn('single_block_id', $blocks->pluck('id'))
            ->orderBy('sort', 'ASC')
            ->get()->groupBy('single_block_id');

        foreach ($blocks as $block) {

            $formattedFields = $this->formatFields($fields[$block->id]);

            foreach ($formattedFields[0] as $field) {

                if ($field->type != 'repeat') {

                    $value = $field->decodeValue($field->value);

                } else {

                    $value = $this->repeat($formattedFields, [], $field->decodeValue($field->value), $field->id);
                }

                $field->value = $value;
            }

            $block->fields = $formattedFields[0];
        }

        return $blocks;
    }

    protected function repeat($formattedFields, $fields, $length, $parent_id)
    {
        foreach ($formattedFields[$parent_id] as $field) {

            if ($field->type != 'repeat') {

                $value = json_decode($field->value);

                $this->repairFieldsByDfs($value, $length);

                $func = function ($item) use (&$func, $field) {
                    return is_array($item) ? array_map($func, $item) : $field->decodeValue($item);
                };

                $value = array_map($func, $value);

            } else {

                $value = $this->repeat($formattedFields, [], $field->decodeValue($field->value), $field->id);
            }

            $newField = $field->toArray();
            $newField['value'] = $value;

            $fields[] = $newField;
        }

        return [
            'fields' => $fields,
            'length' => $length,
        ];
    }

    protected function repairFieldsByDfs(&$value, &$length)
    {
        if (is_numeric($length) && (! is_array($value) || count($value) != $length)) {

            $value = array_fill(0, $length, '');

            return;

        } elseif (! is_numeric($length)) {

            for ($i = 0; $i < count($length); $i++) {

                if (is_array($length[$i])) {

                    $this->repairFieldsByDfs($value[$i], $length[$i]);

                } elseif (! isset($value[$i]) || ! is_array($value[$i]) || count($value[$i]) != $length[$i]) {

                    $value[$i] = array_fill(0, $length[$i], '');
                }
            }
        }
    }

    protected function formatFields($fields)
    {
        $blocks = [];

        foreach ($fields as $field) {

            if (empty($blocks[$field->parent_id])) {

                $blocks[$field->parent_id] = [];
            }

            $blocks[$field->parent_id][] = $field;
        }

        return $blocks;
    }
}
