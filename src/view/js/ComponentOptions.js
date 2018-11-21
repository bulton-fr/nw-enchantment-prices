"use strict";

class ComponentOptions
{
    constructor()
    {
        this.priceFrom   = null;
        this.discountPct = 1;
        this.discounts   = {
            event: false,
            vip8: false,
            vip9: false,
            vip10: false,
            vip11: false,
            vip12: false
        };
        
        this.addEventsOnPricesFrom();
        this.addEventsOnDiscounts();
        
        this.obtainDefaultValues();
        
        document.getElementById('componentSavePriceAH')
                .addEventListener('click', this.saveAllPrices.bind(this));
    }
    
    addEventsOnPricesFrom()
    {
        let radios   = document.querySelectorAll('input[name="components[options][pricesFrom]"]'),
            nbRadios = radios.length
        ;
        
        for (let radioIdx=0; radioIdx < nbRadios; radioIdx++) {
            radios[radioIdx].addEventListener(
                'change',
                this.updatePricesFrom.bind(this)
            );
        }
    }
    
    addEventsOnDiscounts()
    {
        let discounts = document.querySelectorAll('input[name^="components[options][discount]"]'),
            nbDiscounts = discounts.length
        ;
        
        for (let discountIdx=0; discountIdx < nbDiscounts; discountIdx++) {
            discounts[discountIdx].addEventListener(
                'change',
                this.updateDiscounts.bind(this)
            );
        }
    }
    
    obtainDefaultValues()
    {
        this.updatePricesFrom({
            target: document.querySelector('input[name="components[options][pricesFrom]"]:checked')
        }, true);
        
        let discounts = document.querySelectorAll('input[name^="components[options][discount]"]'),
            nbDiscounts = discounts.length
        ;
        
        for (let discountIdx=0; discountIdx < nbDiscounts; discountIdx++) {
            this.updateDiscounts({
                target: discounts[discountIdx]
            }, true);
        } 
    }
    
    updatePricesFrom(event, isInit)
    {
        this.priceFrom = event.target.value;
        
        if (isInit !== true) {
            this.updatePrices();
        }
    }
    
    updateDiscounts(event, isInit)
    {
        let discountType   = event.target.dataset.discountType,
            discountVipLvl = event.target.dataset.discountVipLvl,
            discountStatus = false,
            discountValue
        ;
        
        if (event.target.checked) {
            discountStatus = true;
        }
        
        if (discountType === 'event') {
            discountValue        = 0.15;
            this.discounts.event = discountStatus;
        } else {
            discountValue                        = 0.05;
            this.discounts["vip"+discountVipLvl] = discountStatus;
        }
        
        if (discountStatus === true) {
            this.discountPct -= discountValue;
        } else if (this.discountPct < 1) {
            this.discountPct += discountValue;
        }
        
        if (isInit !== true) {
            this.updatePrices();
        }
    }
    
    updatePrices()
    {
        let componentList = app.componentList;
        
        for (let componentId in componentList) {
            componentList[componentId].updateAllPrices();
        }
    }
    
    saveAllPrices()
    {
        let componentList = app.componentList;
        
        for (let componentId in componentList) {
            componentList[componentId].saveInputValue();
        }
    }
}
