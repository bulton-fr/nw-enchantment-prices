<?php

namespace Modules\I18n;

class FenomModifiers
{
    public static function numberFormat($numberToFormat): string
    {
        $userLang = \BFW\Application::getInstance()
            ->getModuleList()
            ->getModuleByName('I18n')
            ->userLang
        ;
        
        $numberFormat = $userLang->obtainNumberFormat();
        
        return number_format(
            $numberToFormat,
            0,
            $numberFormat->decimalSep,
            $numberFormat->thousandsSep
        );
    }
}
