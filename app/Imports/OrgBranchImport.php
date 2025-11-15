<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrgBranchImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            '0' => new ImportOrgBranch(),
        ];
    }
}
