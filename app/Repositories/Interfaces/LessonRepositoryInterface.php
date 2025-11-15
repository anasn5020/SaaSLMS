<?php

namespace App\Repositories\Interfaces;

interface LessonRepositoryInterface
{
    public function addLesson(object $request): bool|object;
    public function lessons(object $request): object;
    public function lessonDetail(object $request): object;
    public function hosts(): array;
    public function privacies(): object;
    public function updateLesson(object $request): object;
    public function deleteLesson(object $request): bool;
    public function vimeoVideos(object $request): array;
    public function getAllVdocipherData(object $request): array;
    public function getBunnyVideos(object $request): array;
}
