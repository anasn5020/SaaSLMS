<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\CourseSetting\Entities\Category;

class ShowPolicyCategory extends Component
{

    protected $category, $categoryId;
    public $ids = [];


    public function categoryFilter($categoryId)
    {

        if (($key = array_search($categoryId, $this->ids)) !== false) {
            unset($this->ids[$key]);
            $category = Category::where('id', $categoryId)->first();
            $childs = $category->getAllChildIds($category);
            foreach ($childs as $child) {
                if (($key2 = array_search($child, $this->ids)) !== false) {
                    unset($this->ids[$key2]);
                }
            }
        } else {
            array_push($this->ids, $categoryId);
        }

    }

    public function render()
    {
        $categories = Category::where('parent_id', 0)->orWhere('parent_id', null)->orderBy('name', 'asc')->get();
        return view('livewire.show-policy-category', compact('categories'));
    }
}
