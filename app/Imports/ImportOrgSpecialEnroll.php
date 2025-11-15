<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportOrgSpecialEnroll implements WithStartRow, WithHeadingRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

//    public function collection(Collection $collection)
//    {
//        $ids = $collection->whereNotNull('employee_id')->pluck('employee_id');
//        return User::select('name', 'employee_id', 'email')->with('position','branch')->whereIn('employee_id', $ids)->get();
//
//    }

}
