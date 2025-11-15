<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Org\Entities\OrgBranch;

class ShowPolicyBranch extends Component
{


    protected $branch, $branchCode;
    public $codes = [];

    protected $listeners = ['checkOrgChart'];


    public function branchFilter($branchCode)
    {

        if (($key = array_search($branchCode, $this->codes)) !== false) {
            unset($this->codes[$key]);
            $branch = OrgBranch::where('code', $branchCode)->first();
            $childs = $branch->getAllChildIds($branch);
            foreach ($childs as $child){
                if(($key2 = array_search($child, $this->codes)) !== false){
                    unset($this->codes[$key2]);
                }
            }
        } else {
            array_push($this->codes, $branchCode);
        }

    }



    public function render()
    {
        $branches = OrgBranch::where('parent_id',0)->orderBy('order', 'asc')->get();

        return view('livewire.show-policy-branch', [
            'branches' => $branches
        ]);
    }

}
