<?php

namespace Modules\I18n;

class UserLang
{
    protected $availableLangs = [];
    protected $defaultLang = '';
    protected $userLang = '';
    
    protected $numberFormatForLangs = [];
    
    public function __construct()
    {
        $this->availableLangs = ['en', 'fr'];
        $this->defaultLang    = $this->availableLangs[0];
        $this->userLang       = $this->availableLangs[0];
        
        $this->numberFormatForLangs = [
            'en' => $this->createNumberFormat('.', ','),
            'fr' => $this->createNumberFormat(',', ' ')
        ];
        
        $this->detectUserLang();
    }
    
    public function getAvailableLangs(): array
    {
        return $this->availableLangs;
    }
    
    public function getDefaultLang(): string
    {
        return $this->defaultLang;
    }
    
    public function getUserLang(): string
    {
        return $this->userLang;
    }
    
    public function obtainNumberFormat()
    {
        return $this->numberFormatForLangs[$this->userLang];
    }
    
    protected function createNumberFormat($decimalSep, $thousandsSep)
    {
        return new class($decimalSep, $thousandsSep) {
            public $decimalSep = '';
            public $thousandsSep = '';
            
            public function __construct($decimalSep, $thousandsSep)
            {
                $this->decimalSep   = $decimalSep;
                $this->thousandsSep = $thousandsSep;
            }
        };
    }


    protected function detectUserLang()
    {
        $request = \BFW\Request::getInstance();
        
        // HTTP_ACCEPT_LANGUAGE -> fr-FR,fr;q=0.8,en-US;q=0.6,en;q=0.4
        try {
            $acceptLanguage = $request->getServerValue('HTTP_ACCEPT_LANGUAGE');
        } catch (\Exception $e) {
            return; //Because not found in $_SERVER.
        }
        
        $listAcceptedLangs = explode(',', $acceptLanguage);
        foreach ($listAcceptedLangs as $acceptedLangInfo) {
            $langInfo = explode(';', $acceptedLangInfo);
            $langCode = strtolower($langInfo[0]);
            
            if (strpos($langCode, '-') !== false) {
                $minLang  = explode('-', $langCode);
                $langCode = $minLang[0];
            }
            
            if (in_array($langCode, $this->availableLangs)) {
                $this->userLang = $langCode;
                break;
            }
        }
    }
}
