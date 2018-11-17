<?php

namespace Modules\I18n;

class I18n
{
    /**
     * Exception codes : 
     * Category : 9 (module)
     * System : 1 (i18n)
     * Class : 01 (i18n)
     */
    
    const ERR_GET_VALUES_UNKNOWN_ID = 9101001;
    
    protected $userLang;
    
    protected $values = [];
    
    public function __construct(UserLang $userLang)
    {
        $this->userLang = $userLang;
        
        $this->obtainAllI18n();
    }
    
    public function getValues(): array
    {
        return $this->values;
    }
    
    public function getValueForId(int $id): string {
        if (!isset($this->values[$id])) {
            throw new Exception(
                'The key '.$id.' not exist in values list',
                self::ERR_GET_VALUES_UNKNOWN_ID
            );
        }
        
        $currentLang = $this->userLang->getUserLang();
        if (empty($this->values[$id]->{$currentLang})) {
            return $this->values[$id]->{$this->userLang->getDefaultLang()};
        }
        
        return $this->values[$id]->{$currentLang};
    }
    
    protected function obtainAllI18n()
    {
        $mI18n = new \Modeles\I18n;
        
        try {
            $this->formatDbValues($mI18n->getAll());
        } catch (\Exception $e) {
            $errorMsg = 'module i18n : Cannot obtain all i18n values from dabatase.';
            
            \BFW\Application::getInstance()
                ->getMonolog()
                ->getLogger()
                ->error($errorMsg)
            ;
            
            //To display error page.
            trigger_error($errorMsg, E_USER_ERROR);
        }
    }
    
    protected function formatDbValues(array $dbValues)
    {
        foreach ($dbValues as $dbRow) {
            $this->values[$dbRow->idI18n] = (object) [
                'en' => $dbRow->textEn,
                'fr' => $dbRow->textFr
            ];
        }
    }
}
