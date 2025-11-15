<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgMaterial;

class MaterialActionBar extends Component
{
    protected $listeners = ['checkOrgChart'];
    public $type, $showAddBtn = false, $org_chart;


    public function render()
    {
        return view('livewire.material-action-bar');
    }

    public function selectType()
    {
        $this->emit('selectTypeFilter', $this->type);
    }

    public function checkOrgChart($codes)
    {
        if (count($codes) == 1) {
            $this->showAddBtn = true;
            $chart = OrgBranch::where('code', $codes[0] ?? '')->first();
            if ($chart) {
                $this->org_chart = $chart->fullPath;
            }
        } else {
            $this->showAddBtn = false;
        }
    }
}
