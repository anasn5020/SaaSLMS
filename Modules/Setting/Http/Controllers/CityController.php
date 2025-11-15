<?php

namespace Modules\Setting\Http\Controllers;

use App\City;
use App\Country;
use App\State;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{

    public function index(Request $request)
    {
        if ($request->country) {
            $country_search = (int)$request->country;
        } else {
            $country_search = 0;
        }
        if ($request->state) {
            $state_search = (int)$request->state;
        } else {
            $state_search = 0;
        }
        if ($request->name) {
            $city_search = $request->name;
        } else {
            $city_search = '';
        }

        $countries = Country::select('id', 'name')->get();
        $states = State::select('id', 'name')->where('country_id', $country_search)->get();
        $query = City::query();


        if ($request->state) {
            $query->where('state_id', $request->state);
        } else {
            if (!empty($country_search)) {
                $stateIds = State::where('country_id', $country_search)->pluck('id')->toArray();
                $query->whereIn('state_id', $stateIds);

            }
        }

        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        $cities = $query->with(['state', 'state.country'])->paginate(20);
        return view('setting::city.index', [
            "cities" => $cities,
            "countries" => $countries,
            "states" => $states,
            "country_search" => $country_search,
            "city_search" => $city_search,
            "state_search" => $state_search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required',
            'state' => 'required',
        ]);

        try {
            DB::table('spn_cities')->insert([
                'name' => $request->name,
                'state_id' => $request->state,
            ]);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'name' => 'required',
            'state' => 'required',
        ]);
        try {
            DB::table('spn_cities')
                ->where('id', $id)
                ->update([
                    'state_id' => $request->state,
                    'name' => $request->name,
                ]);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            DB::table('spn_cities')->where('id', $id)->delete();
            Toastr::success(__('setting.City has been deleted Successfully'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function edit_modal(Request $request)
    {
        try {
            $city = City::where('id', $request->id)->first();
            $states = State::where('country_id', $city->state->country->id)->get();
            return view('setting::city.edit_modal', [
                "city" => $city,
                "states" => $states
            ]);
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return false;
        }
    }
}
