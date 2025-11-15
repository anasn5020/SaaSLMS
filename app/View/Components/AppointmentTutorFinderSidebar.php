<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseLevel;

class AppointmentTutorFinderSidebar extends Component
{

    public $level;
    public $levels;
    public $type;
    public $categories;
    public $genders;
    public $countries;
    public $language;
    public $weekDays;
    public $mode;
    public $level_ids;
    public $categoriesIds;
    public $gender_ids;
    public $days;
    public $country;
    public $price_rang;
    public $age_rang;

    public function __construct($categories, $levels, $genders, $weekDays, $countries, $categoriesIds, $levelIds, $genderIds, $priceRange, $ageRange, $days, $country, $type)
    {
        $this->categories = $categories;
        $this->levels = $levels;
        $this->genders = $genders;
        $this->weekDays = $weekDays;
        $this->countries = $countries;
        $this->categoriesIds = $categoriesIds;
        $this->levelIds = $levelIds;
        $this->genderIds = $genderIds;
        $this->priceRange = $priceRange;
        $this->ageRange = $ageRange;
        $this->days = $days;
        $this->country = $country;
        $this->type = $type;
       
    }

    public function render()
    {
        $data = [];
        $data['levels'] = CourseLevel::getAllActiveData();
       
     
        return view(theme('components.appointment-tutor-finder-sidebar'), $data);
    }
}
