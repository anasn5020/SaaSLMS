<?php

namespace App\Repositories;

interface CommonRepositoryInterface
{
    public function billingInfo($type = null):array;

}
