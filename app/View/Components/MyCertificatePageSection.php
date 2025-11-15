<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Certificate\Entities\CertificateRecord;

class MyCertificatePageSection extends Component
{
    protected $order;
    protected $query;

    public function __construct($order = null, $query = null)
    {
        $this->order = $order;
        $this->query = $query;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $data = CertificateRecord::when(isModuleActive('CPD'), function ($q) {
            $q->whereNotNull('course_id');
        })->where('student_id', Auth::user()->id);
        if ($this->query) {
            $data->whereHas('course', function ($q) {
                $q->where('courses.title', 'LIKE', "%{$this->query->get('query')}%");
            });
        }
        if ($this->order == 'created_date') {
            $data->orderBy('start_date', 'desc');
        }
        if ($this->order == 'upload_date') {
            $data->orderBy('end_date', 'desc');
        }
        $certificate_records = $data->paginate(6);
        return view(theme('components.my-certificate-page-section'), compact('certificate_records'));

    }
}
