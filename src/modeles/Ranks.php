<?php

namespace Modeles;

class Ranks extends AbstractModeles
{
    protected $tableName = 'ranks';
    
    public function getAllByOrderWithRankBefore()
    {
        $rankBefore = $this->select('object')
            ->from(['rb' => $this->tableName], 'idRank')
            ->where('`rb`.`order`=(`r`.`order` - 1)')
        ;
        
        $req = $this->select('object')
            ->from(['r' => $this->tableName], '*')
            ->subQuery('idRankBefore', $rankBefore)
            ->order('r`.`order')
        ;
        
        return $req->getExecuter()->fetchAll();
    }
}