<?php

namespace Modules\Setting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Http\Requests\SmsGatewayRequest;
use Modules\Setting\Repositories\SmsGatewayRepository;
use App\Traits\SendSMS;

class SmsSettingsController extends Controller
{
    use SendSMS;

    protected $smsGatewayRepo;

    public function __construct(SmsGatewayRepository $smsGatewayRepo)
    {
        $this->middleware('RoutePermissionCheck:admin.sms_settings.index', ['only' => ['index']]);
        $this->middleware('RoutePermissionCheck:admin.sms_settings.create', ['only' => ['create', 'store']]);
        $this->middleware('RoutePermissionCheck:admin.sms_settings.edit', ['only' => ['edit', 'update']]);
        $this->middleware('RoutePermissionCheck:admin.sms_settings.destroy', ['only' => ['destroy']]);
        $this->middleware('RoutePermissionCheck:admin.sms_settings.status', ['only' => ['status']]);
        $this->middleware('RoutePermissionCheck:admin.send_test_sms', ['only' => ['sendTestSms']]);

        $this->smsGatewayRepo = $smsGatewayRepo;
    }

    public function index()
    {
        try {
            $data['sms_gateways'] = $this->smsGatewayRepo->all();
            $data['active_sms_gateways'] = $this->smsGatewayRepo->getActiveAll();

            return view('setting::sms_gateway.index', $data);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function sendTestSms(Request $request)
    {
        $request->validate([
            'receiver_number' => 'required',
            'message' => 'required'
        ]);
        try {
            $this->send_test_sms($request->receiver_number, $request->message);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function create()
    {
        try {
            return view('setting::sms_gateway.create');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function store(SmsGatewayRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->smsGatewayRepo->create($request->all());
            DB::commit();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('admin.sms_settings.index');
        } catch (\Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function show($id)
    {
        try {
            $data['gateway'] = $this->smsGatewayRepo->find($id);
            return view('setting::sms_gateway.show', $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function edit($id)
    {
        try {
            $data['gateway'] = $this->smsGatewayRepo->find($id);
            $data['gateway_params'] = $this->smsGatewayRepo->params($id);
            return view('setting::sms_gateway.create', $data);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(SmsGatewayRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->smsGatewayRepo->update($request->all(), $id);
            DB::commit();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('admin.sms_settings.index');

        } catch (\Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        try {
            $this->smsGatewayRepo->delete($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        try {
            $this->smsGatewayRepo->status($request->all());
            return response()->json([
                'msg' => trans('common.Operation successful'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


}
