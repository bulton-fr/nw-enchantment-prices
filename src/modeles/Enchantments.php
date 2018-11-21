<?php

namespace Modeles;

class Enchantments extends AbstractModeles
{
    protected $tableName = 'enchantments';
    
    public function getAllForType($type)
    {
        $currentLang = \BFW\Application::getInstance()
            ->getModuleList()
            ->getModuleByName('I18n')
            ->userLang
            ->getUserLang()
        ;
        
        $req = $this->select('object')
            ->from(['e' => $this->tableName], '*')
            ->joinLeft(
                ['i' => 'i18n'],
                'i.idI18n=e.idI18n'
            )
            ->where('e.type=:type', [':type' => $type])
            ->order('i`.`text'.ucfirst($currentLang))
        ;
        
        return $req->getExecuter()->fetchAll();
    }
}
