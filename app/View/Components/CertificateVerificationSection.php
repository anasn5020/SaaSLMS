<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CertificateVerificationSection extends Component
{
    public $certificate;

    public function __construct($certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view(theme('components.certificate-verification-section'));
    }
}
