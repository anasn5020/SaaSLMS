<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CPD\Repositories\Interfaces\CpdRepositoryInterface;

class Cpd extends Component
{
    private $cpdRepository;

    public function __construct(
        CpdRepositoryInterface $cpdRepository
    )
    {
        $this->cpdRepository = $cpdRepository;
    }

    public function render()
    {
        $cpds = [];
        if (auth()->user()) {
            $cpds = $this->cpdRepository->studentCpd(auth()->user()->id);
        }
        return view(theme('components.cpd'), compact('cpds'));
    }
}
