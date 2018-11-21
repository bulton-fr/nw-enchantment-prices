<?php

namespace Modeles;

class Components extends AbstractModeles
{
    protected $tableName = 'components';
    
    public function updatePriceAH(int $idCompo, int $rawPrice)
    {
        $updateDate = new \BFW\Helpers\Dates;
        
        return $this->update()
            ->from(
                $this->tableName,
                [
                    'priceAH'    => $rawPrice,
                    'updateDate' => $updateDate->getSqlFormat()
                ]
            )
            ->where('idComponent=:idCompo', [':idCompo' => $idCompo])
            ->execute()
        ;
    }
}
