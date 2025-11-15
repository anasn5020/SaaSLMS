<?php

namespace App\Imports;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportRegularStudent implements ToCollection, WithStartRow, WithHeadingRow
{
//    public function rules(): array
//    {
//        $validate_rules = [
//            'name' => 'required',
//            'email' => 'required|unique:users,email',
//            'password' => 'required|min:8',
//        ];
//
//        request()->validate($validate_rules, validationMessage($validate_rules));
//
//    }

    public function collection(Collection $items)
    {
        foreach ($items as $row) {

            $name = $row['name'] ?? '';
            $email = $row['email'] ?? '';
            $password = $row['password'] ?? '';
            $user = User::where('email', $email)->first();
            if ($user) {
                Toastr::warning($email . ' ' . trans('common.Already Exist'), trans('common.Error'));
            } else {
                if (!empty($email) && !empty($name) && !empty($password)) {
                    $user = User::create([
                        'name' => $name,
                        'email' => strtolower($email),
                        'password' => Hash::make($password),
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                        'role_id' => 3,
                        'referral' => generateUniqueId(),
                        'language_id' => Settings('language_id') ?? '19',
                        'language_name' => Settings('language_name') ?? 'English',
                        'language_code' => Settings('language_code') ?? 'en',
                        'language_rtl' => Settings('language_rtl') ?? '0',
                        'country' => Settings('country_id'),
                        'lms_id' => Auth::user()->lms_id,
                    ]);
                }
            }
            if (isModuleActive('Organization')){
                $user->organization_id = Auth::id();
                $user->save();
            }
            if ($user) {
                applyDefaultRoleToUser($user);
            }

        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
