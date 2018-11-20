<?php

namespace Modules\Tokens;

class Form
{
    protected $inputs = [];
    
    public function getInputs()
    {
        return $this->inputs;
    }
    
    public function createInput(string $name): Input
    {
        $this->inputs[$name] = new Input($name);
        return $this->inputs[$name];
    }
    
    public function newInput(string $name)
    {
        $input = $this->createInput($name);
        $input->updateToken();
        
        return $input;
    }
    
    public function obtainInput(string $name): Input
    {
        if (isset($this->inputs[$name])) {
            return $this->inputs[$name];
        }
        
        return $this->createInput($name);
    }
}
