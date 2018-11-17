"use strict";

//It's an abstract class (but we cannot say that in js...)
class InputFormat
{
    constructor(inputDomElement)
    {
        this.inputDomElement = inputDomElement;
    }
    
    addListeners()
    {
        this.inputDomElement.addEventListener('keyup', this.formatInputValue.bind(this));
    }
    
    obtainRawInputElement(userInputElement)
    {
        //Must be present in children
    }
    
    formatInputValue(event)
    {
        let rawValue = this.updateRawValue(event.target);
        
        if (rawValue === 0) {
            event.target.value = '';
            return;
        }
        
        event.target.value = app.formatValue(rawValue);
    }
    
    updateRawValue(inputElement)
    {
        let userValue = inputElement.value,
            rawValue  = parseInt(userValue.replace(/\D/g,'')) || 0;
        
        if (rawValue > 0) {
            this.obtainRawInputElement(inputElement).value = rawValue;
        } else {
            this.obtainRawInputElement(inputElement).value = '';
        }
        
        return rawValue;
    }
}
