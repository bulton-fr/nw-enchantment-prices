"use strcit";

class Rank
{
    constructor(domElement)
    {
        this.domElement    = domElement;
        this.rankId        = domElement.dataset.rankId;
        this.finalRawPrice = 0;
    }
    
    getFinalRawPrice()
    {
        return this.finalRawPrice;
    }
    
    updatePrice()
    {
        this.finalRawPrice = 0;
        
        let neededComponents = nwep.ranksDetails[this.rankId].components,
            nbCompoForRank,
            compoPrice
        ;
        
        for(let compoId in neededComponents) {
            nbCompoForRank = neededComponents[compoId];
            compoPrice     = app.getComponentForId(compoId).price;
            
            this.finalRawPrice += nbCompoForRank * compoPrice;
        }
        
        let tdPrice = this.domElement.querySelector('td:last-of-type');
        
        tdPrice.innerHTML                = app.formatValue(this.finalRawPrice);
        this.domElement.dataset.rawPrice = this.finalRawPrice;
    }
}
