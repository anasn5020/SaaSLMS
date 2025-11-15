<?php

namespace App\Traits;


use App\DataTableManagement;

trait TableManagement
{
    public function getDataForDatatable($users_table)
    {
        $data['data_table_data'] = DataTableManagement::query()->where('table_name', $users_table);
        $data['tables_data'] = $data['data_table_data']->clone()->where('is_visible', 1)->orderBy('order', 'ASC')->pluck('original_order')->toArray();
        $data['left_tables_data'] = $data['data_table_data']->clone()->where('is_default', 0)->orderBy('id', 'ASC')->get();
        $data['right_tables_data'] = $data['data_table_data']->clone()->where('is_visible', 1)->orderBy('order', 'ASC')->get();
        $data['column_visibility'] = [];
        foreach ($data['data_table_data']->clone()->get() as $datum) {
            $data['column_visibility'][$datum->column_name] = $datum->is_visible;
        }
        $data['export_optn'] = $data['data_table_data']->clone()->where('is_visible', 1)->whereNotIn('column_name', ['select_td', 'action'])->orderBy('order', 'ASC')->pluck('order')->toArray();
        $data['visibility_reset'] = $data['data_table_data']->clone()->where('is_visible', 1)->orderBy('order', 'ASC')->pluck('order')->toArray();

        return $data;
    }
}

