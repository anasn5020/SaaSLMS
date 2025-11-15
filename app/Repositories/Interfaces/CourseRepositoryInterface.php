<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface
{
    public function courses(object $request): object;
    public function changeStatus(object $request): bool;
    public function courseDetail(object $request): object;
    public function courseUpdate(object $request): bool;
    public function categories(object $request): object;
    public function subcategories(object $request): object;
    public function storeCourse(object $request): bool;
    public function levels(object $request): object;
    public function chapterRearrange(object $request): bool;
    public function certificateList(): object;
    public function assignCertificate(object $request): object;
    public function categoryDetail(object $request): object;
    public function categoryStore(object $request): bool;
    public function changeCategoryStatus(object $request): bool;
    public function courseCategoryDelete(object $request): bool;
    public function storeCourseLevel(object $request): bool;
    public function updateCourseLevel(object $request): bool;
    public function changeCourseLevelStatus(object $request): bool;
    public function deleteCourseLevel(object $request): object;
    public function courseDelete(object $request): bool;
    public function categoryUpdate(object $request): bool;
}
