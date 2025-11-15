<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\Org\Entities\OrgMaterial;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOrgMaterial implements FromView,WithStyles
{
    public function view(): View
    {
        $materials = OrgMaterial::with('user')->get();
        return view('org::exports.all_materials', [
            'materials' => $materials
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
