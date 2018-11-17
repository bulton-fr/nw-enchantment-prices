<?php

namespace Api;

class Enchantments extends \BfwApi\Rest
{
    public function postRequest()
    {
        $enchantId = $this->datas['enchantmentId'] ?? null;
        $rankId    = $this->datas['rankId'] ?? null;
        $rawPrice  = $this->datas['price'] ?? null;
        
        if ($enchantId === null || $rankId === null || $rawPrice === null) {
            http_response_code(400);
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
        
        http_response_code(200);
    }
}
