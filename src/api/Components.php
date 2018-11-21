<?php

namespace Api;

class Components extends \BfwApi\Rest
{
    public function postRequest()
    {
        $compoId  = $this->datas['componentId'] ?? null;
        $rawPrice = $this->datas['price'] ?? null;
        $token    = $this->datas['token'] ?? null;
        
        if ($compoId === null || $rawPrice === null || $token === null) {
            http_response_code(400);
            return;
        }
        
        $tokenStatus = $this->checkToken($token, (int) $compoId);
        if ($tokenStatus === false) {
            http_response_code(401);
            
            return;
        }
        
        try {
            $mPrices = new \Modeles\Components;
            $mPrices->updatePriceAH((int) $compoId, (int) $rawPrice);
        } catch (\Exception $e) {
            http_response_code(500);
            return;
        }
        
        $newToken = $this->newToken((int) $compoId);
        $response = (object) [
            'token' => $newToken
        ];
        
        $this->sendResponse($response);
        http_response_code(200);
    }
    
    protected function obtainToken(int $compoId): \Modules\Tokens\Input
    {
        $formToken = \BFW\Application::getInstance()
            ->getModuleList()
            ->getModuleByName('Tokens')
            ->tokens
        ;
        
        return $formToken->obtainInput('components_'.$compoId);
    }
    
    protected function checkToken(string $token, int $compoId): bool
    {
        $tokenInput = $this->obtainToken($compoId);
        
        if ($tokenInput === null) {
            return false;
        } elseif ($tokenInput->getToken()->hasToken() === false) {
            return false;
        }
        
        return $tokenInput->getToken()->checkToken($token);
    }
    
    protected function newToken(int $compoId): string
    {
        $tokenInput = $this->obtainToken($compoId);
        
        if ($tokenInput === null) {
            return false;
        }
        
        return $tokenInput->updateToken();
    }
}
