<?php

namespace Modules\Ranks;

class RanksEnchantments
{
    protected $enchantmentId;
    
    protected $ranks;
    
    protected $prices = [];
    
    protected $isOutdated = true;
    
    public function __construct(int $enchantmentId)
    {
        $this->enchantmentId = $enchantmentId;
        
        $this->obtainRanks();
        $this->obtainPrices();
        $this->checkOutdated();
    }
    
    protected function obtainRanks()
    {
        $mRanks = new \Modeles\Ranks;
        $this->ranks = $mRanks->getAllByOrderWithRankBefore();
    }
    
    protected function obtainPrices()
    {
        $mPrice = new \Modeles\Prices;
        $prices = $mPrice->getAllForEnchantmentId($this->enchantmentId);
        
        foreach ($prices as $priceInfo) {
            $this->prices[$priceInfo->idRank] = $priceInfo;
        }
    }
    
    protected function checkOutdated()
    {
        $current = new \DateTime;
        
        foreach ($this->prices as $priceInfo) {
            $priceDate = new \DateTime($priceInfo->updateDate);
            $dateDiff  = $current->diff($priceDate);
            
            if ($dateDiff->days > 7) {
                $this->isOutdated = true;
                break;
            }
        }
    }
    
    public function generateList(): array
    {
        $rankList = [];
        
        foreach ($this->ranks as $rankInfo) {
            $idRank = $rankInfo->idRank;
            
            $rankList[$idRank] = (object) [
                'idI18n'     => $rankInfo->idI18n,
                'price'      => null,
                'updateDate' => null
            ];
            
            if (!empty($this->prices[$idRank])) {
                $rankList[$idRank]->price      = $this->prices[$idRank]->price;
                $rankList[$idRank]->updateDate = $this->prices[$idRank]->updateDate;
            }
        }
        
        return $rankList;
    }
}
