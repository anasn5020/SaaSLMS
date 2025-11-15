<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Org\Entities\OrgBranch;
use Modules\OrgInstructorPolicy\Entities\OrgPolicyBranch;

class ShowBranch extends Component
{
    protected $branch, $branchCode;
    public $codes = [];

    protected $listeners = ['checkOrgChart'];
    public $edit_branches;

    public function render()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $branches = Cache::rememberForever('org_branches', function () {
                return OrgBranch::withCount('childs')->where('parent_id', 0)->orderBy('order', 'asc')->get();
            });
        } else {
            $policy_id = Auth::user()->policy_id;
            $assign = OrgPolicyBranch::select('branch_id')->where('policy_id', $policy_id)->pluck('branch_id')->toArray();
            $branches = OrgBranch::whereIn('id', $assign)->where('parent_id', 0)->with('childs')->orderBy('order', 'asc')->get();
            foreach ($branches as $branch) {
                if (count($branches->where('id', $branch->parent_id)) == 0) {
                    $branch->parent_id = 0;
                }
            }
        }
        return view('livewire.show-branch', [
            'branches' => $branches
        ]);
    }


    public function branchFilter($branchCode)
    {
        $this->emit('addBranchFilter', $branchCode);
    }

    public function checkOrgChart($codes)
    {
        $this->codes = $codes;
    }

    public function mount($edit_branches = [])
    {
        $this->edit_branches = $edit_branches;
    }

}
