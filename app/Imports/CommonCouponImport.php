<?php

namespace App\Imports;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\Coupons\Entities\Coupon;
use Illuminate\Support\Arr;

class CommonCouponImport implements ToCollection, WithHeadingRow, WithStyles
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $row = $row->toArray();

            if (empty(Arr::get($row, 'start_date')) || empty(Arr::get($row, 'end_date'))){
                continue;
            }

            try {
                $start_date = Carbon::createFromFormat('m/d/Y', Arr::get($row, 'start_date'))->format('Y-m-d');
            } catch (\Exception $e) {
                $start_date = Date::excelToDateTimeObject((int) Arr::get($row, 'start_date'))->format('Y-m-d');
            }
            try {
                $end_date = Carbon::createFromFormat('m/d/Y', Arr::get($row, 'end_date'))->format('Y-m-d');
            } catch (\Exception $e) {
                $end_date = Date::excelToDateTimeObject((int) Arr::get($row, 'end_date'))->format('Y-m-d');
            }

            $row['start_date'] =$start_date;
            $row['end_date'] =$end_date;


              $rules = [
                'title' => 'required|max:255',
                'code' => [
                    'required',
                    Rule::unique('coupons', 'code')->where(function ($query) {
                        if (isModuleActive('LmsSaas')) {
                            return $query->where('lms_id', app('institute')->id);
                        }
                        return $query;
                    }),
                ],
                'amount' => 'required|numeric|min:0',
                'minimum_purchase' => 'required|numeric|min:0',
                'max_discount' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ];

            $validator = Validator::make($row, $rules, validationMessage($rules));

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    Toastr::error("Row " . ($index + 2) . " import failed: " . $error,trans('common.Error'));
                }
                 continue;
            }

            Coupon::create([
                'user_id' => Auth::id(),
                'title' => Arr::get($row, 'title'),
                'code' => Arr::get($row, 'code'),
                'type' => Arr::get($row, 'type', 'Fixed') == 'Fixed' ? 1 : 0,
                'value' => Arr::get($row, 'amount', 0),
                'limit' => (int) Arr::get($row, 'limit', 0),
                'min_purchase' => Arr::get($row, 'minimum_purchase', 0),
                'max_discount' => Arr::get($row, 'max_discount', 0),
                'start_date' => Arr::get($row, 'start_date'),
                'end_date' =>Arr::get($row, 'end_date'),
            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
