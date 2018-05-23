<?php

namespace App\Services\JokeService;

use Exception;

class ApiUnavailableException extends Exception
{
    /**
     * ApiUnavailableException constructor.
     */
    public function __construct()
    {
        parent::__construct('Api server is unavailable', 500);
    }
}