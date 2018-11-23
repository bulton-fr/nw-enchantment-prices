<?php

namespace Modules\Ranks;

class RanksComponents
{
    protected $ranks;
    protected $compos;
    
    public function __construct()
    {
        $this->obtainRanks();
        $this->obtainComponents();
    }
    
    public function generateList(): array
    {
        $ranksDetail = $this->generateDefaultList();
        $this->updateNbComponentFromDb($ranksDetail);
        
        return $ranksDetail;
    }
    
    protected function obtainRanks()
    {
        $mRanks      = new \Modeles\Ranks;
        $this->ranks = $mRanks->getAllByOrderWithRankBefore();
    }
    
    protected function obtainComponents()
    {
        $mComponents = new \Modeles\Components;
        $allCompos   = $mComponents->getAll();
        
        //kill yield
        $this->compos = [];
        foreach ($allCompos as $compoInfo) {
            $this->compos[$compoInfo->idComponent] = $compoInfo;
        }
    }
    
    protected function generateDefaultList()
    {
        $ranksDetail = [];
        foreach ($this->ranks as $rankInfo) {
            $idRank = $rankInfo->idRank;
            
            $ranksDetail[$idRank] = (object) [
                'idI18n'       => $rankInfo->idI18n,
                'idRankBefore' => $rankInfo->idRankBefore,
                'number'       => $rankInfo->number,
                'components'   => []
            ];
            
            foreach ($this->compos as $compoInfo) {
                $compoId = $compoInfo->idComponent;
                $ranksDetail[$idRank]->components[$compoId] = 0;
            }
        }
        
        return $ranksDetail;
    }
    
    protected function updateNbComponentFromDb(array &$ranksDetail)
    {
        $mRanksComponents = new \Modeles\RanksComponents;
        $allRanksCompos   = $mRanksComponents->getAll();
        
        foreach ($allRanksCompos as $rankCompoInfo) {
            $idRank  = $rankCompoInfo->idRank;
            $idCompo = $rankCompoInfo->idComponent;
            
            if (!isset($ranksDetail[$idRank]->components[$idCompo])) {
                continue;
            }
            
            $ranksDetail[$idRank]->components[$idCompo] = $rankCompoInfo->nbComponent;
        }
    }
}
