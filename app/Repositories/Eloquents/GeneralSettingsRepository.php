<?php

namespace App\Repositories\Eloquents;

use App\State;
use App\Country;
use App\Http\Resources\api\v2\GeneralSettings\CityListResource;
use Modules\Setting\Model\TimeZone;
use Modules\Setting\Model\GeneralSetting;
use Modules\SystemSetting\Entities\Currency;
use App\Repositories\Interfaces\GeneralSettingsInterface;
use App\Http\Resources\api\v2\GeneralSettings\CountryListResource;
use App\Http\Resources\api\v2\GeneralSettings\CurrencyListResource;
use App\Http\Resources\api\v2\GeneralSettings\TimezoneListResource;
use App\Http\Resources\api\v2\GeneralSettings\DefaultSettingsResource;
use App\Http\Resources\api\v2\GeneralSettings\StateListResource;
use App\Models\SpnCity;

class GeneralSettingsRepository implements GeneralSettingsInterface
{
    public function defaultSettings(): object
    {
        $setting    = GeneralSetting::pluck('value', 'key')->only('site_title', 'student_reg', 'instructor_reg', 'currency_code', 'currency_symbol');
        return new DefaultSettingsResource($setting);
    }
    public function currencies(object $request): object
    {
        $data = Currency::whereStatus('1')->when($search = $request->search, function ($q) use ($search) {
            $q->whereLike('name', $search);
        })->paginate($request->per_page ?? 10);

        return CurrencyListResource::collection($data);
    }
    public function timezones(object $request): object
    {
        $data = TimeZone::when($search = $request->search, function ($q) use ($search) {
            $q->whereLike('code', $search);
        })->paginate($request->get('per_page', 10));

        return TimezoneListResource::collection($data);
    }
    public function countries(object $request): object
    {
        $countries = Country::where('active_status', 1)
            ->when($search = $request->search, function ($countries) use ($search) {
                $countries->whereLike('name', $search);
            })->paginate($request->get('per_page', 10));

        return CountryListResource::collection($countries);
    }
    public function states(object $request): object
    {
        $state = State::where('country_id', $request->country_id)->when($search = $request->search, function ($states) use ($search) {
            $states->whereLike('name', $search);
        })->paginate($request->get('per_page', 10));

        return StateListResource::collection($state);
    }
    public function cities(object $request): object
    {
        $cities = SpnCity::where('state_id', $request->state_id)
            ->when($search = $request->search, function ($cities) use ($search) {
                $cities->whereLike('name', $search);
            })->select('id', 'name')->paginate($request->get('per_page', 10));

        return CityListResource::collection($cities);
    }
}
