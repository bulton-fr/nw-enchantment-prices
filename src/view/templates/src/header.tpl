<header class="mdl-layout__header nwep-layout__header">
    <div class="mdl-layout__header-row">
        <span class="android-title mdl-layout-title">
            Neverwinter : Enchantments prices
        </span>
        <!-- Add spacer, to align navigation to the right in desktop -->
        <div class="android-header-spacer mdl-layout-spacer"></div>
        <!-- Navigation -->
        <div class="android-navigation-container">
            <nav class="android-navigation mdl-navigation">
                <a
                    class="mdl-navigation__link mdl-typography--text-uppercase"
                    href="#componentsPrices"
                >
                    Components Prices
                </a>
                <a
                    class="mdl-navigation__link mdl-typography--text-uppercase"
                    href="#armorEnchantment"
                    id="menuArmorEnchantment"
                >
                    Armor Enchantments
                </a>
                <a
                    class="mdl-navigation__link mdl-typography--text-uppercase"
                    href="#weaponEnchantment"
                    id="menuWeaponEnchantment"
                >
                    Weapon Enchantments
                </a>
            </nav>
            <div
                class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-grid nwep-menu"
                for="menuArmorEnchantment"
            >
                {foreach $enchantmentList.armor as $enchant index=$index}
                    {if $index % 5 === 0}
                        {if $index > 0}</ul>{/if}
                        <ul class="mdl-cell nwep-menu__list">
                    {/if}
                    <li class="mdl-menu__item">
                        <a href="#{$i18n->getValueForId($enchant->idI18n)}">
                            {$i18n->getValueForId($enchant->idI18n)}
                        </a>
                    </li>
                {/foreach}
                </ul>
            </div>
            <div
                class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-grid nwep-menu"
                for="menuWeaponEnchantment"
            >
                {foreach $enchantmentList.weapon as $enchant index=$index}
                    {if $index % 5 === 0}
                        {if $index > 0}</ul>{/if}
                        <ul class="mdl-cell nwep-menu__list">
                    {/if}
                    <li class="mdl-menu__item">
                        <a href="#{$i18n->getValueForId($enchant->idI18n)}">
                            {$i18n->getValueForId($enchant->idI18n)}
                        </a>
                    </li>
                {/foreach}
                </ul>
            </div>
        </div>
    </div>
</header>