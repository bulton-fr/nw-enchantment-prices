<?php

namespace Modeles;

abstract class AbstractModeles extends \BfwSql\AbstractModeles
{
    public function getAll()
    {
        $req = $this->select('object')
            ->from($this->tableName, '*')
        ;
        
        return iterator_to_array($req->getExecuter()->fetchAll());
    }
}
