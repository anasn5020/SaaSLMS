<?php

namespace App\View\Components\Backend;

use Illuminate\View\Component;

class Status extends Component
{
    public $id, $status, $route, $org_id;

    public function __construct($id, $status, $route = null, $org = null)
    {
        $this->id = $id;
        $this->status = $status;
        $this->route = $route;
        $this->org_id = $org;
    }

    public function render()
    {
        return view(backendComponent('status'));
    }
}
