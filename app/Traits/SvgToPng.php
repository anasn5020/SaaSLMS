<?php

namespace App\Traits;

use DOMDocument;

trait SvgToPng
{

    public function getDefaultColor($src)
    {
        $svg = file_get_contents($src);
        $dom = new DOMDocument();
        $dom->loadXML($svg);
        $element = $dom->getElementsByTagName('svg');
        $value = $element[0]->getAttribute('fill');
        return $value;
    }


}
