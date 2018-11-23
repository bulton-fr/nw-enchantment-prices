<?php

namespace Modules\Ranks;

class RanksEnchantments
{
    protected $enchantmentId;
    
    protected $ranks;
    
    protected $prices = [];
    
    public function __construct(int $enchantmentId)
    {
        $this->enchantmentId = $enchantmentId;
        
        $this->obtainRanks();
        $this->obtainPrices();
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
    
    protected function checkOutdated(int $idRank): bool
    {
        $current   = new \DateTime;
        $priceDate = new \DateTime($this->prices[$idRank]->updateDate);
        $dateDiff  = $current->diff($priceDate);
        
        if ($dateDiff->days > 7) {
            return true;
        }
        
        return false;
    }
    
    public function generateList(): array
    {
        $rankList = [];
        
        foreach ($this->ranks as $rankInfo) {
            $idRank = $rankInfo->idRank;
            
            $rankList[$idRank] = (object) [
                'idI18n'     => $rankInfo->idI18n,
                'price'      => null,
                'updateDate' => null,
                'isOutdated' => false,
            ];
            
            if (!empty($this->prices[$idRank])) {
                $rankList[$idRank]->price      = $this->prices[$idRank]->price;
                $rankList[$idRank]->updateDate = $this->prices[$idRank]->updateDate;
                $rankList[$idRank]->isOutdated = $this->checkOutdated($idRank);
            }
        }
        
        return $rankList;
    }
}
