<?php

namespace App\Exports;


use App\StudentCustomField;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfflineStudentExport implements FromCollection
{

    public function collection()
    {
        $custom_field = StudentCustomField::getData();


        if ($custom_field->show_name == 1) {
            $excel_column[0][] = 'name';
            $excel_column[1][] = 'Offline Student';
        }
        $excel_column[0][] = 'email';
        $excel_column[0][] = 'phone';

        $excel_column[1][] = 'demo@gmail.com';
        $excel_column[1][] = '0123232323';

        if ($custom_field->show_company == 1) {
            $excel_column[0][] = 'company';
            $excel_column[1][] = 'Demo Company';
        }
        if ($custom_field->show_gender == 1) {
            $excel_column[0][] = 'gender';
            $excel_column[1][] = 'male';
        }
        if ($custom_field->show_student_type == 1) {
            $excel_column[0][] = 'student_type';
        }
        if ($custom_field->show_identification_number == 1) {
            $excel_column[0][] = 'identification_number';
            $excel_column[1][] = '123456789';
        }
        if ($custom_field->show_job_title == 1) {
            $excel_column[0][] = 'job_title';
            $excel_column[1][] = 'Demo Job Title';
        }
        $excel_column[0][] = 'dob';
        $excel_column[0][] = 'country';

        $excel_column[1][]= '10-25-1999';
        $excel_column[1][] = '1';

        return collect([$excel_column]);
    }
}
