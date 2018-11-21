<?php

use \BFW\Helpers\Cli;

$mI18n   = new \Modeles\I18n;
$allI18n = $mI18n->getAll();

Cli::displayMsgNL('Read all i18n lines ...');

foreach ($allI18n as $i18nInfo) {
    Cli::displayMsg('> Read for "'.$i18nInfo->textEn.'" ... ');
    
    if (!empty($i18nInfo->ref)) {
        Cli::displayMsgNL('Ref already exist', 'yellow');
        continue;
    }
    
    $ref = str_replace(
        ' ',
        '-',
        strtolower(trim($i18nInfo->textEn))
    );
    
    $mI18n->updateRef($i18nInfo->idI18n, $ref);
    Cli::displayMsgNL('Created', 'green');
}

Cli::displayMsgNL('');
Cli::displayMsgNL('Done.');