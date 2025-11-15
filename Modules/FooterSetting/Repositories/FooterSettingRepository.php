<?php

namespace Modules\FooterSetting\Repositories;


use Modules\FooterSetting\Entities\FooterSetting;

class FooterSettingRepository
{


    public function update($data, $id)
    {
        $setting =FooterSetting::where('key',$data['key'])->first();
        foreach ($data['value'] as $key => $value) {
            $setting->setTranslation('value', $key, $value);
        }
        $setting->save();
//        UpdateGeneralSetting($data['key'], $data['value']);
    }

    public function edit($id)
    {
        $footer = $this->footer->findOrFail($id);
        return $footer;
    }

    public function getAll()
    {
        return FooterSetting::all();
    }
}
