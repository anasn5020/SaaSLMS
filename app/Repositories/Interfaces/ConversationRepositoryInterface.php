<?php

namespace App\Repositories\Interfaces;

interface ConversationRepositoryInterface
{
    public function list(object $request): object;
    public function contactList(object $request): object;
    public function messages(object $request): object;
    public function storeMessage(object $request): object;
}
