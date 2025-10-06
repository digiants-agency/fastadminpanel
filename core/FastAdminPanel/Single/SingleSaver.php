<?php

namespace App\FastAdminPanel\Single;

use App\FastAdminPanel\Models\SingleBlock;
use App\FastAdminPanel\Models\SingleField;
use App\FastAdminPanel\Models\SinglePage;
use Lang;

class SingleSaver
{
    protected $page;

    protected $sorts = [];

    public function setPage($data)
    {
        $page = SinglePage::where('slug', $data['slug'])->first();

        if (empty($page)) {

            $page = new SinglePage($data);
            $page->save();

        } else {

            $page->title = $data['title'];
            $page->slug = $data['slug'];
            $page->sort = $data['sort'];
            $page->icon = $data['icon'];
            $page->dropdown_slug = $data['dropdown_slug'];
            $page->save();
        }

        $this->page = $page;
    }

    public function save($blocks)
    {
        $singleBlocksIdsToDelete = SingleBlock::select('id')
            ->where('single_page_id', $this->page->id)
            ->whereNotIn('slug', array_column($blocks, 'slug'))
            ->get();

        SingleBlock::whereIn('id', $singleBlocksIdsToDelete)
            ->delete();

        foreach (Lang::all() as $lang) {
            (new SingleField($lang->tag))->whereIn('single_block_id', $singleBlocksIdsToDelete)
                ->delete();
        }

        foreach ($blocks as $blockIndex => $block) {

            $block['sort'] = $blockIndex + 1;
            $block['single_page_id'] = $this->page->id;

            $singleBlock = SingleBlock::updateOrCreate(
                [
                    'slug' => $block['slug'],
                    'single_page_id' => $block['single_page_id'],
                ],
                $block
            );

            $this->saveFields($block, $singleBlock->id);
        }
    }

    public function saveFields($block, $singleBlockId, $parentId = 0)
    {
        $fieldsSlugs = [];

        foreach ($block['fields'] as $fieldIndex => $field) {

            unset($field['id']);

            $field['sort'] = $fieldIndex + 1;
            $field['single_block_id'] = $singleBlockId;
            $field['parent_id'] = $parentId;
            $field['value'] = ! empty($field['value']) ? $field['value'] : '';

            $singleField = SingleField::where('slug', $field['slug'])
                ->where('single_block_id', $field['single_block_id'])
                ->where('parent_id', $field['parent_id'])
                ->first();

            if (empty($singleField)) {

                foreach (Lang::all() as $lang) {
                    $singleField = (new SingleField($lang->tag))->create($field);
                    $singleField->value = $field['type'] == 'repeat' ? 0 : $singleField->encodeValue($field['value'] ?? $singleField->default());
                    $singleField->save();
                }

            } else {

                foreach (Lang::all() as $lang) {

                    $singleField = (new SingleField($lang->tag))->where('slug', $field['slug'])
                        ->where('single_block_id', $field['single_block_id'])
                        ->where('parent_id', $field['parent_id'])
                        ->first();

                    $singleField->is_multilanguage = $field['is_multilanguage'];
                    $singleField->sort = $field['sort'];
                    $singleField->title = $field['title'];
                    $singleField->type = $field['type'];
                    $singleField->save();
                }
            }

            $fieldsSlugs[] = $field['slug'];

            if ($field['type'] == 'repeat') {
                $this->saveFields($field, $singleBlockId, $singleField->id);
            }
        }

        foreach (Lang::all() as $lang) {
            (new SingleField($lang->tag))->where('single_block_id', $singleBlockId)
                ->where('parent_id', $parentId)
                ->whereNotIn('slug', $fieldsSlugs)
                ->delete();
        }
    }

    public function remove()
    {
        $pageId = $this->page->id;

        $this->page->delete();

        $blocksToDelete = SingleBlock::where('single_page_id', $pageId)
            ->get(['id'])
            ->pluck('id');

        SingleBlock::whereIn('id', $blocksToDelete)
            ->delete();

        foreach (Lang::all() as $lang) {
            (new SingleField($lang->tag))->whereIn('single_block_id', $blocksToDelete)
                ->delete();
        }
    }
}
