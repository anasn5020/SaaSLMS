<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Org\Entities\OrgPosition;

class ShowPosition extends Component
{
    public $edit_positions;

    public function render()
    {
        $positions = OrgPosition::orderBy('order')->get();
        return view('livewire.show-position', compact('positions'));
    }

    public function mount($edit_positions = [])
    {
        $this->edit_positions = $edit_positions;
    }
}
