"use strict";

class Component extends InputFormat
{
    constructor(domElement)
    {
        let componentId = domElement.dataset.componentId,
            input       = document.getElementById('componentsPrice['+componentId+'][formated]');
        
        super(input);
        
        this.domElement  = domElement;
        this.componentId = componentId;
        
        this.price = nwep.components[this.componentId].price;
        
        super.addListeners();
        input.addEventListener('blur', this.updateAllPrices.bind(this));
    }
    
    obtainRawInputElement()
    {
        return document.getElementById("componentsPrice["+this.componentId+"][raw]");
    }
    
    updateRawValue(inputElement)
    {
        let rawValue = super.updateRawValue(inputElement);
        
        this.price = rawValue;
        
        return rawValue;
    }
    
    updateAllPrices()
    {
        for (let rankId in app.rankList) {
            app.rankList[rankId].updatePrice();
        }
        
        for (let enchantmentId in app.enchantList) {
            app.enchantList[enchantmentId].updateComparison();
        }
    }
}
