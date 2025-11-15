<?php


namespace Modules\AoraPageBuilder\Repositories;


use Modules\FrontendManage\Entities\FrontPage;

class PageBuilderRepository
{

    public function designUpdate(array $data, $id)
    {
        $page = FrontPage::where('id', $id)->first();
        return $page->setTranslation('details', $data['lang'], $data['body'])
            ->save();
    }


}
