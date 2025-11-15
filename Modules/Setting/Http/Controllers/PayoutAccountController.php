<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\UserPayoutAccount;
use Modules\Setting\Entities\UserPayoutAccountSpecification;
use Modules\Setting\Repositories\PayoutAccountRepository;

class PayoutAccountController extends Controller
{
    protected $payoutAccountRepo;

    public function __construct(PayoutAccountRepository $payoutAccountRepo)
    {
        $this->middleware('RoutePermissionCheck:admin.payout_accounts.index', ['only' => ['index']]);
        $this->middleware('RoutePermissionCheck:admin.payout_accounts.store', ['only' => ['create', 'store']]);
        $this->middleware('RoutePermissionCheck:admin.payout_accounts.update', ['only' => ['edit', 'update']]);
        $this->middleware('RoutePermissionCheck:admin.payout_accounts.destroy', ['only' => ['destroy']]);
        $this->middleware('RoutePermissionCheck:admin.payout.settings', ['only' => ['settings', 'settingsSubmit']]);
        $this->payoutAccountRepo = $payoutAccountRepo;
    }

    public function index()
    {
        try {
            $data['payout_accounts'] = $this->payoutAccountRepo->all();
            return view('setting::payout_accounts.index', $data);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function create()
    {
        try {
            return view('setting::payout_accounts.form');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function store(Request $request)
    {
         $rules = [
            "title" => "required",
            "logo" => "required",
            'specifications.0.specification'=>"required"

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            DB::beginTransaction();
            $this->payoutAccountRepo->create($request->all());
            DB::commit();
            $data['payout_accounts'] = $this->payoutAccountRepo->all();
            return response()->json([
                'response' => (string)view('setting::payout_accounts.list', $data),
                'msg' => trans('common.Operation successful'),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function show($id)
    {
        try {
            $data['payout_account'] = $this->payoutAccountRepo->find($id);
            return view('setting::payout_accounts.show', $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function edit($id)
    {
        try {
            $data['payout_account'] = $this->payoutAccountRepo->find($id);
            return view('setting::payout_accounts.form', $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:150',
        ]);
        try {
            DB::beginTransaction();
            $this->payoutAccountRepo->update($request->all(), $id);
            DB::commit();
            $data['payout_accounts'] = $this->payoutAccountRepo->all();
            return response()->json([
                'response' => (string)view('setting::payout_accounts.list', $data),
                'msg' => trans('common.Operation successful'),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->payoutAccountRepo->delete($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function settingsSubmit(Request $request)
    {
        $request->validate([
            'minimum_payout_amount' => 'required|numeric|gt:0',
        ]);
        try {
            UpdateGeneralSetting('minimum_payout_amount', $request->minimum_payout_amount);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function settings()
    {
        try {
            return view('setting::payout_accounts.settings');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function userPayoutAccount($id)
    {
        try {
            $data['user_payout_account'] = UserPayoutAccount::with(['payoutAccount'])->where('user_id', $id)->first();
            $data['user_payout_account_specifications'] = UserPayoutAccountSpecification::with(['specification'])->where('user_id', $id)->get();
            return view('setting::payout_accounts._user_payout_account_modal', $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

}
