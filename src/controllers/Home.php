<?php

namespace Controller;

class Home extends \BfwController\Controller
{
    protected $tpl;
    
    protected $tplVars = [];
    
    protected $i18n;

    public function __construct()
    {
        parent::__construct();
        
        $moduleList = $this->app->getModuleList();
        
        $this->tpl  = $moduleList->getModuleByName('bfw-fenom')->fenom;
        $this->i18n = $moduleList->getModuleByName('I18n')->i18n;
        
        $this->tplVars['tokens'] = \BFW\Application::getInstance()
            ->getModuleList()
            ->getModuleByName('Tokens')
            ->tokens
        ;
        
        $this->tplVars['i18n'] = $this->i18n;
    }
    
    public function index()
    {
        $this->obtainComponentsList();
        $this->obtainRanksDetails();
        
        $this->tplVars['enchantmentList'] = [];
        $this->obtainEnchantmentList('armor');
        $this->obtainEnchantmentList('weapon');
        
        $numberFormat = \BFW\Application::getInstance()
            ->getModuleList()
            ->getModuleByName('I18n')
            ->userLang
            ->obtainNumberFormat()
        ;
        
        $this->tplVars['numberFormat'] = $numberFormat;
        
        $this->tplVars['page'] = 'home.tpl';
        $this->tpl->display('layout.tpl', $this->tplVars);
    }
    
    protected function obtainComponentsList()
    {
        $mComponents = new \Modeles\Components;
        $allCompo    = $mComponents->getAll();
        $compoList   = [];
        
        foreach ($allCompo as $componentInfo) {
            $compoList[$componentInfo->idComponent] = $componentInfo;
        }
        
        $this->tplVars['componentList'] = $compoList;
    }
    
    protected function obtainRanksDetails()
    {
        $ranksComponents = new \Modules\Ranks\RanksComponents;
        $this->tplVars['ranksDetails'] = $ranksComponents->generateList();
    }
    
    protected function obtainEnchantmentList($enchantmentType)
    {
        $mEnchantments = new \Modeles\Enchantments;
        
        $allEnchantments = $mEnchantments->getAllForType($enchantmentType);
        $enchantmentList = [];
        
        foreach ($allEnchantments as $enchantment) {
            $enchantmentId = $enchantment->idEnchantment;
            $ranks         = new \Modules\Ranks\RanksEnchantments($enchantmentId);
            
            $enchantmentList[$enchantmentId] = (object) [
                'idI18n' => $enchantment->idI18n,
                'ranks'  => $ranks->generateList()
            ];
        }
        
        $this->tplVars['enchantmentList'][$enchantmentType] = $enchantmentList;
    }
}
