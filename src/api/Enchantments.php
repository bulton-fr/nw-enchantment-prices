<?php

namespace Api;

class Enchantments extends \BfwApi\Rest
{
    public function postRequest()
    {
        $enchantId = $this->datas['enchantmentId'] ?? null;
        $rankId    = $this->datas['rankId'] ?? null;
        $rawPrice  = $this->datas['price'] ?? null;
        $token     = $this->datas['token'] ?? null;
        
        if (
            $enchantId === null ||
            $rankId === null ||
            $rawPrice === null ||
            $token === null
        ) {
            http_response_code(400);
            return;
        }
        
        $tokenStatus = $this->checkToken($token, (int) $enchantId, (int) $rankId);
        if ($tokenStatus === false) {
            http_response_code(401);
            
            var_dump($_SESSION);
            
            return;
        }
        
        try {
            $mPrices = new \Modeles\Prices;
            $mPrices->updatePrice(
                (int) $enchantId,
                (int) $rankId,
                (int) $rawPrice
            );
        } catch (\Exception $e) {
            http_response_code(500);
            return;
        }
        
        $newToken = $this->newToken((int) $enchantId, (int) $rankId);
        $response = (object) [
            'token' => $newToken
        ];
        
        $this->sendResponse($response);
        http_response_code(200);
    }
    
    protected function obtainToken(
        int $enchantId,
        int $rankId
    ): \Modules\Tokens\Input {
        $formToken = \BFW\Application::getInstance()
            ->getModuleList()
            ->getModuleByName('Tokens')
            ->tokens
        ;
        
        $tokenInput = $formToken->obtainInput(
            'enchants_'.$enchantId.'_'.$rankId
        );
        
        return $tokenInput;
    }
    
    protected function checkToken(
        string $token,
        int $enchantId,
        int $rankId
    ): bool {
        $tokenInput = $this->obtainToken($enchantId, $rankId);
        
        if ($tokenInput === null) {
            return false;
        } elseif ($tokenInput->getToken()->hasToken() === false) {
            return false;
        }
        
        return $tokenInput->getToken()->checkToken($token);
    }
    
    protected function newToken(int $enchantId, int $rankId): string
    {
        $tokenInput = $this->obtainToken($enchantId, $rankId);
        
        if ($tokenInput === null) {
            return false;
        }
        
        return $tokenInput->updateToken();
    }
}
