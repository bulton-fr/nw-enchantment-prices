"use strict";

class Component extends InputFormat
{
    constructor(domElement)
    {
        let componentId = domElement.dataset.componentId,
            inputs      = [
                document.getElementById('componentsPrice['+componentId+'][ah][formated]'),
                document.getElementById('componentsPrice['+componentId+'][bazaar][formated]'),
            ],
            nbInputs    = inputs.length
        ;
        
        super();
        
        this.domElement  = domElement;
        this.componentId = componentId;
        this.component   = nwep.components[this.componentId]
        this.price       = this.component.price;
        
        for (let inputIdx=0; inputIdx < nbInputs; inputIdx++) {
            if (inputs[inputIdx] === null) {
                continue;
            }
            
            inputs[inputIdx].addEventListener('keyup', this.formatInputValue.bind(this));
            inputs[inputIdx].addEventListener('blur', this.updateAllPrices.bind(this));
        }
    }
    
    obtainRawInputElement(inputElement)
    {
        let priceFrom = inputElement.dataset.componentPriceFrom;
        
        return document.getElementById("componentsPrice["+this.componentId+"]["+priceFrom+"][raw]");
    }
    
    saveInputValue(resolve, reject)
    {
        let fakeDataset = {dataset: {componentPriceFrom: "ah"}},
            rawValue    = this.obtainRawInputElement(fakeDataset).value,
            token       = this.obtainTokenValue();
        
        let ajax = new Utils_Ajax(
            '/api/components',
            {
                success: function(xhr) {
                    let response = JSON.parse(xhr.responseText),
                        token    = response.token;
                    
                    this.updateToken(token);
                    
                    resolve();
                }.bind(this),
                error: function(xhr) {
                    reject();
                }.bind(this)
            },
            'POST'
        );
        
        ajax.setRequestHeader('Content-Type', 'application/json');
        ajax.setRequestHeader('Accept', 'application/json');
        
        let datas = {
            componentId: this.componentId,
            price: rawValue,
            token: token
        };
        
        ajax.run(JSON.stringify(datas));
    }
    
    obtainTokenValue()
    {
        let inputTokenName = "componentsPrice["+this.componentId+"][token]";
        
        return document.getElementById(inputTokenName).value;
    }
    
    updateToken(newToken)
    {
        let inputTokenName = "componentsPrice["+this.componentId+"][token]";
        
        document.getElementById(inputTokenName).value = newToken;
    }
    
    updateAllPrices()
    {
        this.updateUsedPrice();
        
        for (let rankId in app.rankList) {
            app.rankList[rankId].updatePrice();
        }
        
        for (let enchantmentId in app.enchantList) {
            app.enchantList[enchantmentId].updateComparison();
        }
    }
    
    updateUsedPrice()
    {
        let compoOptions   = app.componentOptions(),
            priceInputName = 'componentsPrice['+this.componentId+']['+compoOptions.priceFrom+'][raw]'
        ;
        
        this.price = document.getElementById(priceInputName).value;
        
        if (compoOptions.priceFrom === 'bazaar' && this.component.intoBazaar) {
            /**
             * We use Math.round because with js :
             * console.debug(0.85 - 0.05);
             * > 0.7999999999999999
             * 
             * So, for example, I obtain the price 59999.99999999998
             * Seriously ... T-T
             */
            this.price *= compoOptions.discountPct;
            this.price = Math.round(this.price); //NOT DOING round ON LINE BEFORE !!
        }
        
        document.getElementById('componentsPrice['+this.componentId+'][raw]').value = this.price;
        
        let usedPriceTxtSelector = 'td[data-component-id="'+this.componentId+'"] span';
        document.querySelector(usedPriceTxtSelector).innerHTML = app.formatValue(this.price);
    }
}
