"use strict";

class Enchantment extends InputFormat
{
    constructor(domElement)
    {
        super();
        
        this.domElement  = domElement;
        this.enchantId   = domElement.dataset.enchantId;
        this.enchantType = domElement.dataset.enchantType;
        this.ranksPrice  = {};
        
        for(let rankId in nwep.ranksDetails) {
            this.ranksPrice[rankId] = {
                upgrade: null,
                ah: null
            };
        }
        
        this.addListeners();
        this.obtainAhPrices();
    }
    
    addListeners()
    {
        let priceInputs = this.domElement.querySelectorAll('input[type="text"]'),
            nbInput     = priceInputs.length;
        
        for (let inputIndex=0; inputIndex<nbInput; inputIndex++) {
            priceInputs[inputIndex].addEventListener('keyup', this.formatInputValue.bind(this));
            priceInputs[inputIndex].addEventListener('blur', this.saveInputValue.bind(this));
            priceInputs[inputIndex].addEventListener('blur', this.updateComparison.bind(this));
        }
    }
    
    obtainAhPrices()
    {
        let rankElement;
        
        for(let rankId in nwep.ranksDetails) {
            rankElement = document.getElementById("enchantmentPrices[ah][raw]["+this.enchantId+"]["+rankId+"]");
            
            this.ranksPrice[rankId].ah = parseInt(rankElement.value) || 0;
        }
    }
    
    obtainRawInputElement(userInputElement)
    {
        let rankId       = userInputElement.dataset.rankId,
            rawInputName = "enchantmentPrices[ah][raw]["+this.enchantId+"]["+rankId+"]";
        
        return document.getElementById(rawInputName);
    }
    
    updateRawValue(inputElement)
    {
        let rawValue = super.updateRawValue(inputElement),
            rankId   = inputElement.dataset.rankId;
        
        this.ranksPrice[rankId].ah = rawValue;
        
        return rawValue;
    }
    
    saveInputValue(event)
    {
        let rankId   = event.target.dataset.rankId,
            rawValue = this.obtainRawInputElement(event.target).value,
            token    = this.obtainTokenValue(rankId);
        
        let ajax = new Utils_Ajax(
            '/api/enchantments',
            {
                success: function(xhr) {
                    //Display update ok
                    let response = JSON.parse(xhr.responseText),
                        token    = response.token;
                    
                    this.updateToken(rankId, token);
                }.bind(this),
                error: function(xhr) {
                    //Display update error
                }.bind(this)
            },
            'POST'
        );
        
        ajax.setRequestHeader('Content-Type', 'application/json');
        ajax.setRequestHeader('Accept', 'application/json');
        
        let datas = {
            enchantmentId: this.enchantId,
            rankId: rankId,
            price: rawValue,
            token: token
        };
        
        ajax.run(JSON.stringify(datas));
    }
    
    obtainTokenValue(rankId)
    {
        let inputTokenName = "enchantmentPrices[token]["+this.enchantId+"]["+rankId+"]";
        
        return document.getElementById(inputTokenName).value;
    }
    
    updateToken(rankId, newToken)
    {
        let inputTokenName = "enchantmentPrices[token]["+this.enchantId+"]["+rankId+"]";
        
        document.getElementById(inputTokenName).value = newToken;
    }
    
    updateComparison()
    {
        for(let rankId in nwep.ranksDetails) {
            this.updateUpgradePrice(rankId);
            this.updateComparisonColor(rankId);
        }
    }
    
    updateUpgradePrice(rankId)
    {
        let idRankBefore    = nwep.ranksDetails[rankId].idRankBefore,
            componentsPrice = app.getRankForId(rankId).getFinalRawPrice(),
            finalPrice      = componentsPrice;
        
        if (idRankBefore !== null) {
            let rankBeforeInfo = this.ranksPrice[idRankBefore],
                rankBeforePrice;
            
            if (rankBeforeInfo.ah === 0) {
                rankBeforePrice = rankBeforeInfo.upgrade;
            } else if (rankBeforeInfo.upgrade < rankBeforeInfo.ah) {
                rankBeforePrice = rankBeforeInfo.upgrade;
            } else {
                rankBeforePrice = rankBeforeInfo.ah;
            }
            
            finalPrice += rankBeforePrice;
        }
    
        this.ranksPrice[rankId].upgrade = finalPrice;
        
        let upgradeSpanId   = 'enchantmentPrices[upgrade]['+this.enchantId+']['+rankId+']',
            upgradeSpanElem = document.getElementById(upgradeSpanId);
        
        upgradeSpanElem.innerHTML        = app.formatValue(finalPrice);
        upgradeSpanElem.dataset.rawValue = finalPrice;
    }
    
    updateComparisonColor(rankId)
    {
        let upgradeId    = 'enchantmentPrices[upgrade]['+this.enchantId+']['+rankId+']',
            upgradeElem  = document.getElementById(upgradeId),
            upgradePrice = parseInt(upgradeElem.dataset.rawValue, 10);
            
        let ahId    = 'enchantmentPrices[ah][raw]['+this.enchantId+']['+rankId+']',
            ahElem  = document.getElementById(ahId),
            ahPrice = parseInt(ahElem.value, 10);
        
        if (upgradePrice === 0 || ahPrice === 0) {
            return;
        }
        
        const CSS_COLOR_SAME   = 'nwep-enchantments__comparison--same',
            CSS_COLOR_CHEAPEST = 'nwep-enchantments__comparison--cheapest',
            CSS_COLOR_MOST_EXP = 'nwep-enchantments__comparison--most-expensive';
    
        let upgradeParentClasses = upgradeElem.parentNode.classList,
            ahParentClasses      = ahElem.parentNode.parentNode.classList;
        
        upgradeParentClasses.remove(CSS_COLOR_SAME);
        upgradeParentClasses.remove(CSS_COLOR_CHEAPEST);
        upgradeParentClasses.remove(CSS_COLOR_MOST_EXP);
        
        ahParentClasses.remove(CSS_COLOR_SAME);
        ahParentClasses.remove(CSS_COLOR_CHEAPEST);
        ahParentClasses.remove(CSS_COLOR_MOST_EXP);
        
        if (upgradePrice === ahPrice) {
            upgradeParentClasses.add(CSS_COLOR_SAME);
            ahParentClasses.add(CSS_COLOR_SAME);
        } else if (upgradePrice < ahPrice) {
            upgradeParentClasses.add(CSS_COLOR_CHEAPEST);
            ahParentClasses.add(CSS_COLOR_MOST_EXP);
        } else if (upgradePrice > ahPrice) {
            upgradeParentClasses.add(CSS_COLOR_MOST_EXP);
            ahParentClasses.add(CSS_COLOR_CHEAPEST);
        }
    }
}
