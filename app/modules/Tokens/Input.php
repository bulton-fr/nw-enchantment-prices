<?php

namespace Modules\Tokens;

class Input
{
    protected $name;
    
    protected $token;
    
    protected $tokenValue = '';
    
    public function __construct($name)
    {
        $this->name  = $name;
        $this->token = new \BFW\Helpers\Form($this->name);
    }
    
    public function __toString()
    {
        return $this->tokenValue;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getToken()
    {
        return $this->token;
    }
    
    public function getTokenValue()
    {
        return $this->tokenValue;
    }
        
    public function updateToken():string
    {
        $this->tokenValue = $this->token->createToken();
        
        return $this->tokenValue;
    }
}
