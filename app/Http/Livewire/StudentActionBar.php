<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Org\Entities\OrgBranch;
use Rappasoft\LaravelLivewireTables\Traits\WithFilters;
use Rappasoft\LaravelLivewireTables\Traits\WithSearch;

class StudentActionBar extends Component
{
    use WithSearch;
    use WithFilters;

    public $positions, $pos, $showAddBtn = false, $org_chart;

    protected $listeners = ['checkOrgChart', 'refreshDatatable' => '$refresh'];

    public function mount($positions)
    {
        $this->positions = $positions;
        $this->pos = null;
        $this->showAddBtn = false;
        $this->org_chart = '';

        $this->emit('refreshDatatable');

    }

    public function render()
    {
        return view('livewire.student-action-bar');
    }

    public function selectPosition()
    {
        $this->emit('addPositionFilter', $this->pos);
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

//    livewire table search
    public function resetPage()
    {

    }


}
