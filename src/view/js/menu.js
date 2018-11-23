const menu = (function() {
    "use strict";
    
    function init() {
        let menus   = document.querySelectorAll('.nwep-menu'),
            nbMenus = menus.length;
        
        for (let menuIndex = 0; menuIndex < nbMenus; menuIndex++) {
            menus[menuIndex].addEventListener('transitionend', changeSize);
        }
    }
    
    function changeSize(event) {
        if (event.target.classList.contains('nwep-menu') === false) {
            return;
        }
        
        let width   = '700px',//event.target.width,
            height  = event.target.height,
            parent  = event.target.parentNode,
            outline = parent.querySelector('.mdl-menu__outline');
        
        event.target.style.clip = 'unset';
        
        parent.style.width  = width;
        parent.style.height = height;
        parent.style.right  = 0;
        parent.style.left   = 'initial';
        
        outline.style.width  = width;
        outline.style.height = height;
        
        let allMenus = document.querySelectorAll('.nwep-menu'),
            nbMenus  = allMenus.length
        ;
        
        for (let menuIdx=0; menuIdx < nbMenus; menuIdx++) {
            allMenus[menuIdx].style.width = width;
        }
    }
    
    return {
        init: init
    };
})();
