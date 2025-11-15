<?php

namespace App\Imports;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\OrgSubscription\Entities\OrgAttendance;

class OrgAttandanceImport implements WithMultipleSheets, WithStartRow, WithHeadingRow, ToCollection
{
    public function sheets(): array
    {
        return [
            '0' => new OrgAttandanceImport(),
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    private function validAttendValue($value)
    {
        $arr = ['A', 'L', 'O'];
        if (in_array($value, $arr)) {
            return true;
        } else {
            return false;
        }
    }

    public function collection(Collection $rows)
    {
        $score = [];
        $toArray = $rows->sortBy('name')->toArray();
        foreach ($toArray as $key => $row) {
            $serial = ++$key;
            try {
                $error = 0;
                $id = explode('-', base64_decode($row['id']));
                $user_id = $id[0];
                $course_id = $id[1];
                $class_id = $id[2];

                if (empty($row['attend'])) {
                    Toastr::error(trans('org.Attend is required') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    $error++;
                }

                if (!empty($row['total_score'])) {
                    if (!is_numeric($row['total_score'])) {
                        $error++;
                        Toastr::error(trans('org.Total Score Is Not Numeric') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    }

                    if (empty($row['pass_rate'])) {
                        $error++;
                        Toastr::error(trans('org.Pass Role is required') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    }
                    if (empty($row['actual_score'])) {
                        $error++;
                        Toastr::error(trans('org.Actual Score is required') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    }

                    if (!is_numeric($row['pass_rate'])) {
                        $error++;
                        Toastr::error(trans('org.Pass Rate Is Not Numeric') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    }

                    if (!is_numeric($row['actual_score'])) {
                        $error++;
                        Toastr::error(trans('org.Actual Score Is Not Numeric') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    }

                    if ($row['pass_rate'] > 100) {
                        $error++;
                        Toastr::error(trans('org.Pass Rate can not grater then 100') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    }

                    if ($row['actual_score'] > $row['total_score']) {
                        $error++;
                        Toastr::error(trans('org.Actual score can not grater then total score') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                    }

                    if (isset($score[$course_id])) {
                        if ($score[$course_id] != $row['total_score']) {
                            $error++;
                            Toastr::error(trans('org.Same course total must be same') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                        }
                    } else {
                        $score[$course_id] = $row['total_score'];
                    }

                }


                if (!$this->validAttendValue($row['attend'])) {
                    $error++;
                    Toastr::error(trans('org.Invalid Input') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));
                }


                if ($error != 0) {
                    continue;
                }
                $attandance = OrgAttendance::where('user_id', $user_id)->where('course_id', $course_id)->first();
                if (!$attandance) {
                    $attandance = new OrgAttendance();
                }
                $pass = 0;
                if (isset($row['pass_rate']) && isset($row['actual_score']) && isset($row['total_score'])) {
                    $actual_rate = getPercentage($row['actual_score'], $row['total_score']);
                    if ($actual_rate >= $row['pass_rate']) {
                        $pass = 1;
                    }
                }


                $attandance->user_id = $user_id;
                $attandance->course_id = $course_id;
                $attandance->class_id = $class_id;
                $attandance->attend = Str::upper($row['attend'] ?? 'A');
                $attandance->total_score = $row['total_score'] ?? 0;
                $attandance->pass_rate = $row['pass_rate'] ?? 0;
                $attandance->actual_score = $row['actual_score'] ?? 0;
                $attandance->pass = $pass;
                $attandance->class_type = !empty($class_id) ? 1 : 2;
                $attandance->save();
            } catch (\Exception $e) {
                Toastr::error(trans('common.Something Went Wrong') . ', ' . trans('org.For row') . ' ' . $serial, trans('common.Failed'));

            }
        }
    }
}
