<?php

namespace Modeles;

class Prices extends AbstractModeles
{
    protected $tableName = 'prices';
    
    public function getAllForEnchantmentId(int $idEnchantment)
    {
        $req = $this->select('object')
            ->from($this->tableName, '*')
            ->where(
                'idEnchantment=:idEnchantment',
                [':idEnchantment' => $idEnchantment]
            )
        ;
        
        return $req->getExecuter()->fetchAll();
    }
    
    public function create($idEnchant, $idRank)
    {
        $updateDate = new \BFW\Helpers\Dates;
        
        return $this->insert()
            ->into(
                $this->tableName,
                [
                    'idEnchantment' => $idEnchant,
                    'idRank'        => $idRank,
                    'updateDate'    => $updateDate->getSqlFormat()
                ]
            )
            ->execute()
        ;
    }
    
    public function updatePrice(int $idEnchant, int $idRank, int $rawPrice)
    {
        $updateDate = new \BFW\Helpers\Dates;
        
        return $this->update()
            ->from(
                $this->tableName,
                [
                    'price'      => $rawPrice,
                    'updateDate' => $updateDate->getSqlFormat()
                ]
            )
            ->where('idEnchantment=:idEnchant', [':idEnchant' => $idEnchant])
            ->where('idRank=:idRank', [':idRank' => $idRank])
            ->execute()
        ;
    }
}