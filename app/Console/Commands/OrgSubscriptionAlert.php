<?php

namespace App\Console\Commands;


use App\Jobs\PushNotificationJob;
use App\Jobs\SendGeneralEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\OrgSubscription\Entities\OrgSubscriptionCheckout;
use Modules\OrgSubscription\Entities\OrgSubscriptionSetting;

class OrgSubscriptionAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:orgSubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert before expire org subscription plan';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::alert('org subscription alert');

        if (isModuleActive('OrgSubscription')) {
            $settings = OrgSubscriptionSetting::get();

            $checkouts = OrgSubscriptionCheckout::whereDate('end_date', '>', Carbon::now())->get();

            $now = Carbon::now();

            foreach ($checkouts as $checkout) {
                $plan = $checkout->plan;
                $totalCompleted = $plan->totalCompleted();
                $percentage = $totalCompleted['totalProgress'] ?? 0;
                if ($percentage != 100) {
                    foreach ($settings->where('type', $checkout->type)->where('event', '!=', 'WhenEnrollment') as $setting) {
                        $event = $setting->event;
                        $template = '';
                        $shortcode = [];
                        $sendNotification = false;
                        if ($checkout->type == 1) {

                            $startDate = Carbon::parse($plan->join_date);
                            $endDate = Carbon::parse($plan->end_date);
                            $numberOfDays = $endDate->diffInDays($startDate);
                            $alertDate = null;

                            if ($event == 'BeforeClassStart') {
                                $template = 'ORG_Class_Study';
                                $shortcode = [
                                    'title' => isset($plan->assign[0]) ? $plan->assign[0]->course->title : '',
                                    'endDate' => Carbon::createFromFormat('m/d/Y', $plan->end_date)->format('d/m/Y'),
                                    'afterStart' => $setting->days,
                                    'student' => $checkout->user->name,
                                    'venue' => $plan->offline_venue,
                                ];
                                if ($numberOfDays >= $setting->days && $percentage == 0) {
                                    $alertDate = Carbon::parse($plan->join_date)->addDays($setting->days);
                                    if ($now->diffInDays($alertDate) == 0) {
                                        $sendNotification = true;
                                    }
                                }

                            } elseif ($event == 'BeforeExpire') {
                                $template = 'ORG_Class_Before_Expire';
                                $shortcode = [
                                    'title' => isset($plan->assign[0]) ? $plan->assign[0]->course->title : '',
                                    'expireDate' => Carbon::createFromFormat('m/d/Y', $plan->end_date)->format('d/m/Y'),
                                    'beforeExpire' => $setting->days,
                                    'student' => $checkout->user->name,
                                    'venue' => $plan->offline_venue,
                                ];

                                if ($numberOfDays >= $setting->days) {
                                    $alertDate = Carbon::parse($plan->end_date)->subDays($setting->days);
                                    if ($now->diffInDays($alertDate) == 0) {
                                        $sendNotification = true;
                                    }
                                }
                            }
                        } else {

                            $startDate = Carbon::parse($checkout->start_date);
                            $endDate = Carbon::parse($checkout->end_date);
                            $numberOfDays = $endDate->diffInDays($startDate);
                            $alertDate = null;

                            if ($event == 'AfterEnrollment') {
                                $template = 'ORG_Path_Study';
                                $shortcode = [
                                    'plan' => $plan->title,
                                    'time' => Carbon::now()->format('d-M-Y, g:i A'),
                                    'expireDate' => showDate($checkout->end_date),
                                    'student' => $checkout->user->name,
                                    'afterStart' => $setting->days,
                                ];

                                if ($numberOfDays >= $setting->days && $percentage == 0) {
                                    $alertDate = Carbon::parse($plan->join_date)->addDays($setting->days);
                                    if ($now->diffInDays($alertDate) == 0) {
                                        $sendNotification = true;
                                    }
                                }

                            } elseif ($event == 'BeforeExpire') {
                                $template = 'ORG_Path_Before_Expire';
                                $shortcode = [
                                    'plan' => Carbon::now()->format('d-M-Y, g:i A'),
                                    'expireDate' => showDate($checkout->end_date),
                                    'student' => $checkout->user->name,
                                    'beforeExpire' => $setting->days,
                                ];

                                if ($numberOfDays >= $setting->days) {
                                    $alertDate = Carbon::parse($plan->end_date)->subDays($setting->days);
                                    if ($now->diffInDays($alertDate) == 0) {
                                        $sendNotification = true;
                                    }
                                }

                            }
                        }

                        if (!empty($template) && $sendNotification) {


                            if ($setting->email == 1 && UserEmailNotificationSetup($template, $checkout->user)) {
                                SendGeneralEmail::dispatch($checkout->user, $template, $shortcode);
                            }

                            if ($setting->browser == 1 && UserBrowserNotificationSetup($template, $checkout->user)) {
                                send_browser_notification($checkout->user, $template, $shortcode,
                                    '',//actionText
                                    ''//actionUrl
                                );
                            }
                            if ($setting->mobile == 1) {
                                send_mobile_notification($checkout->user, $template, $shortcode);
                            }


                        }

                    }

                }

            }

            return true;

        }
    }
}
