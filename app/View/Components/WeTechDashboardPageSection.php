<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\Slider;
use Modules\Org\Entities\OrgLeaderboard;

class WeTechDashboardPageSection extends Component
{


    public function render()
    {
        $user = Auth::user();
        $sliders = Slider::where('status', 1)->get();
        $query = Blog::with('userRead')->where('status', 1);

        if (isModuleActive('Org')) {
            $query->where(function ($q) {
                $q->where('audience', 1)
                    ->orWhere(function ($q) {
                        $q->where('audience', 2);
                        if (Auth::check()) {
                            if (Auth::user()->role_id != 1) {
                                $q->whereHas('branches', function ($q) {
                                    $q->whereIn('branch_id', getAllChildCodeIds(Auth::user()->branch, [Auth::user()->branch->id]));
                                });
                            }
                        } else {
                            $q->whereHas('branches', function ($q) {
                                $q->where('branch_id', 0);
                            });
                        }
                    });
            });

            $query->where(function ($q) {
                $q->where('position_audience', 1)
                    ->orWhere(function ($q) {
                        $q->where('position_audience', 2);
                        if (Auth::check()) {
                            if (Auth::user()->role_id != 1) {
                                $q->whereHas('positions', function ($q) {
                                    $q->whereIn('position_id', getAllChildCodeIds(Auth::user()->position, [Auth::user()->position->id]));
                                });
                            }
                        } else {
                            $q->whereHas('positions', function ($q) {
                                $q->where('position_id', 0);
                            });
                        }
                    });
            });
        }
        $blogs = $query->limit(5)->latest()->get();
        $open_courses = Course::where('required_type', 0)
            ->orderBy('updated_at', 'desc')
            ->where('status', 1)
            ->whereIn('type', [1, 2])
            ->get();

        $totalBadges = $user->userLatestBadges->count();
        $totalCertificate = $user->totalCertificate();
        $leaderboardQuery = OrgLeaderboard::query();

        $leaderboards = $leaderboardQuery->with(['users', 'users.user', 'users.user.branch', 'users.user.position'])->get();


        $query = User::select('id', 'name', 'image', 'gamification_points', 'gamification_total_points', 'user_level');

        $query->withCount('userBadges');

        $data['students'] = $query->where('status', 1)
            ->where('role_id', 3)
            ->where('teach_via', 1)
            ->orderBy('gamification_total_points', 'desc')
            ->get();

        $data['student'] = User::select('id', 'name', 'image', 'gamification_points', 'gamification_total_points', 'user_level')
            ->whereHas('userBadges.badge', function ($q) {
                $q->where('status', 1);
            })
            ->with('userBadges', 'userBadges.badge')
            ->withCount('userBadges')
            ->where('id', Auth::user()->id)->first();


        //badge
        return view(theme('components.we-tech-dashboard-page-section'), $data, compact('sliders', 'blogs', 'open_courses', 'totalCertificate', 'totalBadges', 'leaderboards'));

    }
}
