let app = (function() {
    "use strict";
    
    let componentOptions = null,
        componentList    = {},
        rankList         = {},
        enchantList      = {};
    
    function init() {
        menu.init();
        componentOptionsInit();
        
        componentsInit();
        ranksInit();
        enchantmentsInit();
    }
    
    function getComponentForId(componentId) {
        return componentList[componentId];
    }
    
    function getRankForId(rankId) {
        return rankList[rankId];
    }
    
    function getEnchantmentForId(enchantId) {
        return enchantList[enchantId];
    }
    
    function componentOptionsInit() {
        componentOptions = new ComponentOptions;
    }
    
    function componentsInit() {
        let components   = document.querySelectorAll('.nwep-js-component-item'),
            nbComponents = components.length,
            ComponentElem,
            ComponentId;
        
        for (let componentIndex=0; componentIndex < nbComponents; componentIndex++) {
            ComponentElem = components[componentIndex];
            ComponentId   = ComponentElem.dataset.componentId;
            
            componentList[ComponentId] = new Component(ComponentElem);
            componentList[ComponentId].updateAllPrices();
        }
        
        //componentOptions.updatePrices();
    }
    
    function ranksInit() {
        let ranks   = document.querySelectorAll('.nwep-ranks__item'),
            nbRanks = ranks.length,
            rankElem,
            rankId;
        
        for (let rankIndex=0; rankIndex < nbRanks; rankIndex++) {
            rankElem = ranks[rankIndex];
            rankId   = rankElem.dataset.rankId;
            
            rankList[rankId] = new Rank(rankElem);
            rankList[rankId].updatePrice();
        }
    }
    
    function enchantmentsInit() {
        let enchantments   = document.querySelectorAll('.nwep-enchantments__item'),
            nbEnchantments = enchantments.length,
            enchantElem,
            enchantId;
        
        for (let enchantIndex=0; enchantIndex < nbEnchantments; enchantIndex++) {
            enchantElem = enchantments[enchantIndex];
            enchantId   = enchantElem.dataset.enchantId;
            
            enchantList[enchantId] = new Enchantment(enchantElem);
            enchantList[enchantId].updateComparison();
        }
    }
    
    function formatValue(rawValue) {
        let userLang = navigator.language || navigator.userLanguage;
        
        return Intl.NumberFormat(userLang).format(rawValue);
    }
    
    return {
        init: init,
        formatValue: formatValue,
        componentOptions: function() {
            return componentOptions;
        },
        componentList: componentList,
        rankList: rankList,
        enchantList: enchantList,
        getComponentForId: getComponentForId,
        getRankForId: getRankForId,
        getEnchantmentForId: getEnchantmentForId
    };
})();
