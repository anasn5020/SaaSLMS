<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Modules\Affiliate\Entities\AffiliateCommission;
use Modules\Affiliate\Http\Requests\AffiliateLinkRequest;
use Modules\Affiliate\Http\Requests\AffiliateWithdrawRequest;
use Modules\Affiliate\Http\Requests\BalanceTransferRequest;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\Affiliate\Repositories\AffiliateTransactionRepository;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\CourseSetting\Entities\Course;
use Modules\Subscription\Entities\CourseSubscription;

class AffiliateController extends Controller
{
    protected $affiliateRepo, $affiliateTransactionRepo;


    public function __construct(AffiliateRepository $affiliateRepo, AffiliateTransactionRepository $affiliateTransactionRepo)
    {
        config(['auth.defaults.guard' => 'api']);

        $this->affiliateRepo = $affiliateRepo;
        $this->affiliateTransactionRepo = $affiliateTransactionRepo;
    }

    public function statistics(Request $request)
    {

        $user = $request->user();
        $data = $this->affiliateRepo->getStatistics($user, $request->get('from'), $request->get('to'));


        $response = [
            'success' => true,
            'data' => $data,
            'message' => "Getting Data",
        ];
        return response()->json($response);
    }

    public function links(Request $request)
    {
        $data = $this->affiliateRepo->all();
        $response = [
            'success' => true,
            'data' => $data,
            'message' => "Getting Data",
        ];
        return response()->json($response);

    }

    public function commissions(Request $request)
    {
        $data['user_income_data'] = $this->affiliateTransactionRepo->userWiseIncome($request->get('from'), $request->get('to'));

        $response = [
            'success' => true,
            'data' => $data,
            'message' => "Getting Data",
        ];
        return response()->json($response);

    }

    public function withdraws(Request $request)
    {
        $data = $this->affiliateTransactionRepo->userWiseWithdraw($request->get('from'), $request->get('to'));
        $response = [
            'success' => true,
            'data' => $data,
            'message' => "Getting Data",
        ];
        return response()->json($response);
    }

    public function addLink(AffiliateLinkRequest $request)
    {
        $parsedUrl = parse_url($request->url);
        $host = parse_url(URL::to('/'), PHP_URL_HOST);

        if (!isset($parsedUrl['host']) || $parsedUrl['host'] !== $host) {
            $response = [
                'success' => false,
                'message' => "Invalid URL",
            ];
            return response()->json($response, 422);
        }

        $this->affiliateRepo->create($request->validated());
        $response = [
            'success' => true,
             'message' => "Link Created Successfully",
        ];
        return response()->json($response);
    }

    public function addPaypal(Request $request)
    {
        $validate_rules = [
            'paypal_account' => 'required',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));
        $paypal = $this->affiliateRepo->addOrUpdatePaypalAccount($request->all());


        $response = [
            'success' => true,
            'paypal'=> $paypal->paypal_account,
            'message' => "Updated Successfully",
        ];
        return response()->json($response);
    }

    public function getPaypal(Request $request)
    {
        $response = [
            'success' => true,
            'data' => $this->affiliateRepo->getPaypalAccount(),
            'message' => "getting data",
        ];
        return response()->json($response);
    }

    public function balanceTransfer(BalanceTransferRequest $request)
    {
        try {

            DB::beginTransaction();
            $this->affiliateTransactionRepo->balanceTransferToWallet($request->validated());
            DB::commit();
            $response = [
                'success' => true,
                 'message' => "Successfully Transferred",
            ];
            return response()->json($response);
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' =>$e->getMessage(),
            ];
            return response()->json($response);
        }
    }


    public function withdrawRequest(AffiliateWithdrawRequest $request)
    {
        try {
             DB::beginTransaction();
            $this->affiliateTransactionRepo->withdrawRequest($request->validated());
            DB::commit();
            $response = [
                'success' => true,
                'message' => "Successfully send withdraw request",
            ];
            return response()->json($response);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function getList()
    {

        $commission =AffiliateCommission::select('id','commable_id','commission_for')->get();
        $data =[];
        $courses  = Course::select('id','title')
            ->whereIn('id',$commission->where('commission_for','course')->pluck('commable_id')->toArray())
            ->where('status', 1)->get();
         foreach ($courses as $course) {
            $data['courses'][$course->id] = $course->title;
        }

        if (isModuleActive('BundleSubscription')) {
            $bundles=BundleCoursePlan::select('id','title')
                ->whereIn('id',$commission->where('commission_for','bundle')->pluck('commable_id')->toArray())
                ->where('status', 1)->get();
            foreach ($bundles as $bundle) {
                $data['bundles'][$bundle->id] = $bundle->title;
            }
        }
        if (isModuleActive('Subscription')) {
            $plans=CourseSubscription::select('id','title')
                ->whereIn('id',$commission->where('commission_for','subscription')->pluck('commable_id')->toArray())
                ->where('status', 1)->get();
            foreach ($plans as $plan) {
                $data['plans'][$plan->id] = $plan->title;
            }
        }

        $response = [
            'success' => true,
            'data' => $data,
            'message' => "Getting Data",
        ];
        return response()->json($response);
    }
}
