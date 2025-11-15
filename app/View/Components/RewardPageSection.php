<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Setting\Entities\UserGamificationPoint;

class RewardPageSection extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $data['user'] = $user = Auth::user();
        $data['totalConvert'] = $user->offlinePayments->where('type', 'Reward')->sum('amount');
        $data['total_earn'] = $user->gamification_total_points;
        $data['total_spend'] = $user->gamification_total_spent_points;
        $data['total_remind'] = $user->gamification_total_points - $user->gamification_total_spent_points;

        $data['histories'] = UserGamificationPoint::where('user_id', $user->id)->where('point', '!=', 0)->latest()->paginate(5);
        $data['points'] = User::select('id', 'name', 'image', 'gamification_points', 'gamification_total_points', 'user_level')->where('status', 1)
            ->where('role_id', 3)
            ->where('teach_via', 1)
            ->limit(7)
            ->orderBy('gamification_total_points', 'desc')->get();
        return view(theme('components.reward-page-section'), $data);
    }
}
