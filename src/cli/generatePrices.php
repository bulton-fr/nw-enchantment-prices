<?php

use \BFW\Helpers\Cli;

Cli::displayMsg('> Obtain actual prices ... ');

$mPrices   = new \Modeles\Prices;
$allPrices = $mPrices->getAll();
$priceList = [];

foreach ($allPrices as $priceInfo) {
    $priceList[$priceInfo->idEnchantment][$priceInfo->idRank] = $priceInfo->price;
}

Cli::displayMsgNL('Done', 'yellow');
Cli::displayMsgNL('Read all enchantments');

$mEnchantments   = new \Modeles\Enchantments;
$allEnchantments = $mEnchantments->getAll();
$enchantList     = [];

foreach ($allEnchantments as $enchantInfo) {
    $idEnchant = $enchantInfo->idEnchantment;
    $ranks     = new \Modules\Ranks\RanksEnchantments($idEnchant);
    $ranksList = $ranks->generateList();
    
    Cli::displayMsgNL('> Read for enchantment #'.$idEnchant);
    
    foreach ($ranksList as $idRank => $rankInfo) {
        if (
            !array_key_exists($idEnchant, $priceList) ||
            !array_key_exists($idRank, $priceList[$idEnchant])
        ) {
            Cli::displayMsg('>> Create line for enchant '.$idEnchant.' and rank '.$idRank.' ... ');
            
            try {
                $mPrices->create((int) $idEnchant, (int) $idRank);
                Cli::displayMsgNL('OK', 'green');
            } catch (\Exception $e) {
                Cli::displayMsgNL('Error', 'red');
                Cli::displayMsgNL('#'.$e->getCode().' : '.$e->getMessage(), 'red');
            }
        }
    }
}

Cli::displayMsgNL('');
Cli::displayMsgNL('All enchantments readed', 'yellow');
