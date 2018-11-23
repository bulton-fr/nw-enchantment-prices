<?php

$this->userLang = new \Modules\I18n\UserLang;
$this->i18n     = new \Modules\I18n\I18n($this->userLang);

\BFW\Application::getInstance()
    ->getModuleList()
    ->getModuleByName('bfw-fenom')
    ->fenom
    ->addModifier(
        'number_format',
        ['\Modules\I18n\FenomModifiers', 'numberFormat']
    )
;
