<?php

namespace MilkyWay\BaseSdk\Traits;
use MilkyWay\BaseSdk\Auth;

trait AuthTrait {
    
    protected Auth $auth;

    public function auth(Auth $auth):self {
        return $this->auth = $auth;
    }
}