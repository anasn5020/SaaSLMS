<?php

namespace App\Repositories;

interface UserRepositoryInterface
{


    public function create(array $data);

    public function find(int $id);


    public function store(array $data);

    public function update(array $data, $id);

    public function findDocument(int $id);

    public function storeVerificationCode($email);
}
