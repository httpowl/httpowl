<?php

namespace App\Services;

class Base
{
    protected $context;

    public function __construct(\Illuminate\Console\Command $context)
    {
        $this->context = $context;
    }
}
