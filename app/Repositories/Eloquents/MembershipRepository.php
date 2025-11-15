<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\api\v2\Membership\MembershipLevelsResource;
use App\Http\Resources\api\v2\Membership\MembershipMembersResource;
use App\Repositories\Interfaces\MembershipRepositoryInterface;
use Modules\Membership\Entities\MembershipLevel;
use Modules\Membership\Entities\MembershipPlanCheckout;

class MembershipRepository implements MembershipRepositoryInterface
{
    public function levels(object $request): object
    {
        $levels = MembershipLevel::when($search = $request->search, function ($levels) use ($search) {
            $levels->whereLike('title', $search);
        })->paginate($request->get('per_page', 10));
        return MembershipLevelsResource::collection($levels);
    }

    public function members(object $request): object
    {
        $members = MembershipPlanCheckout::where('current_level', $request->membership_level)
            ->when($search = $request->search, function ($members) use ($search) {
                $members->whereHas('user', function ($user) use ($search) {
                    $user->whereLike('name', $search);
                });
            })->paginate($request->get('per_page', 10));

        return MembershipMembersResource::collection($members);
    }
}
