<?php

namespace Modeles;

class Enchantments extends AbstractModeles
{
    protected $tableName = 'enchantments';
    
    public function getAllForType($type)
    {
        $req = $this->select('object')
            ->from($this->tableName, '*')
            ->where('type=:type', [':type' => $type])
        ;
        
        return $req->getExecuter()->fetchAll();
    }
}
