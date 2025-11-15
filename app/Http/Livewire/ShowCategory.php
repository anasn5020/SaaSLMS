<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CourseSetting\Entities\Category;
use Modules\OrgInstructorPolicy\Entities\OrgPolicyCategory;

class ShowCategory extends Component
{
    protected $category, $categoryCode;
    public $codes = [];

    protected $listeners = ['checkCategory'];

    public function checkCategory($codes)
    {
        $this->codes = $codes;
    }

    public function categoryFilter($category_id)
    {
        $this->emit('addCategoryFilter', $category_id);
    }

    public function render()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $categories = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        } else {
            $policy_id = Auth::user()->policy_id;
            $assign = OrgPolicyCategory::where('policy_id', $policy_id)->pluck('category_id')->toArray();
            $categories = Category::whereIn('id', $assign)->orderBy('name', 'asc')->get();
            foreach ($categories as $category) {
                if (count($categories->where('id', $category->parent_id)) == 0) {
                    $category->parent_id = 0;
                }
            }
        }
        return view('livewire.show-category', [
            'categories' => $categories
        ]);
    }
}
