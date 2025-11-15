<?php
namespace App\Repositories\Interfaces;

interface UserNotificationRepositoryInterface{
    public function notificationList(object $request): object;
    public function markAllAsRead(): bool;
}
