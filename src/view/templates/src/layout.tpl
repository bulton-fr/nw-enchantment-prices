<html>
    <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
        <link rel="stylesheet" href="/assets/css/app.css">
    </head>
    <body class="mdl-layout mdl-js-layout mdl-layout--fixed-header nwep-layout">
        {include "header.tpl"}
        
        <script>
            let nwep = {};
        </script>

        <main class="mdl-layout__content mdl-color--grey-100 mdl-color-text--grey-700 mdl-base nwep-layout__content">
            {include "{$page}"}
        </main>
        
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
        <script defer src="/assets/js/utils/ajax.js"></script>
        <script defer src="/assets/js/InputFormat.js"></script>
        <script defer src="/assets/js/ComponentOptions.js"></script>
        <script defer src="/assets/js/Component.js"></script>
        <script defer src="/assets/js/Rank.js"></script>
        <script defer src="/assets/js/Enchantment.js"></script>
        <script defer src="/assets/js/menu.js"></script>
        <script defer src="/assets/js/app.js"></script>
        <script defer src="/assets/js/global.js"></script>
    </body>
</html>