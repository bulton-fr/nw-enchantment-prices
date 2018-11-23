<?php

namespace Modeles;

class I18n extends AbstractModeles
{
    protected $tableName = 'i18n';
    
    public function updateRef($idI18n, $newRef)
    {
        return $this->update()
            ->from($this->tableName, ['ref' => $newRef])
            ->where('idI18n=:idI18n', [':idI18n' => $idI18n])
            ->execute()
        ;
    }
}