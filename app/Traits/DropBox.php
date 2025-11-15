<?php

namespace App\Traits;

trait DropBox
{
    public function listFolder($query=null)
    {
        if (!$query) {
            $query = generalSetting('folder_name');
        }

        return \Dcblogdev\Dropbox\Facades\Dropbox::files()->listContents($query);
    }

    public function createFolder($name)
    {
        return \Dcblogdev\Dropbox\Facades\Dropbox::files()->createFolder($name);
    }

}
