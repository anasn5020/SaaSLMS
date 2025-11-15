<?php

namespace Modules\Setting\Repositories;

use Illuminate\Support\Facades\Cache;
use Modules\Setting\Model\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        return Currency::orderBy('name', 'asc')->get();
    }

    public function create(array $data)
    {
        $currency = new Currency();
        $currency->fill([
            "name" => $data['name'],
            "code" => $data['code'],
            "symbol" => html_entity_decode($data['symbol']),
            "conversion_rate" => $data['conversion_rate'],
        ])->save();
        Cache::forget('currencyList_' . SaasDomain());
    }

    public function find($id)
    {
        return Currency::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        Cache::forget('currencyList_' . SaasDomain());
        return Currency::findOrFail($id)->update([
            "name" => $data['name'],
            "code" => $data['code'],
            "symbol" => html_entity_decode($data['symbol']),
            "conversion_rate" => $data['conversion_rate'],
        ]);

    }

    public function delete($id)
    {
        Cache::forget('currencyList_' . SaasDomain());
        return Currency::findOrFail($id)->delete();
    }
}
