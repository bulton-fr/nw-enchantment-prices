<section
    id="componentsPrices"
    class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp nwep-layout__content__section nwep-components"
>
    <div class="mdl-card mdl-cell mdl-cell--12-col">
        <div class="mdl-card__supporting-text mdl-grid nwep-card">
            <h2 class="mdl-cell mdl-cell--8-col mdl-typography--title nwep-card__title">
                {$i18n->getValueForRef('components-prices')}
            </h2>
            <div class="mdl-cell mdl-cell--4-col mdl-typography--text-right">
                <button
                    class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                    id="componentSavePriceAH"
                >
                    {$i18n->getValueForRef('save-ah-prices')}
                </button>
            </div>
            <div class="mdl-cell mdl-cell--12-col nwep-components__options">
                {$i18n->getValueForRef('use-prices-from')} :
                <label
                    class="mdl-radio mdl-js-radio mdl-js-ripple-effect"
                    for="componentsOptionsUsePriceFromAH"
                >
                    <input
                        type="radio"
                        id="componentsOptionsUsePriceFromAH"
                        class="mdl-radio__button"
                        name="components[options][pricesFrom]"
                        value="ah"
                        checked
                    >
                    <span class="mdl-radio__label">{$i18n->getValueForRef('action-house')}</span>
                </label>
                <label
                    class="mdl-radio mdl-js-radio mdl-js-ripple-effect"
                    for="componentsOptionsUsePriceFromBazaar"
                >
                    <input
                        type="radio"
                        id="componentsOptionsUsePriceFromBazaar"
                        class="mdl-radio__button"
                        name="components[options][pricesFrom]"
                        value="bazaar"
                    >
                    <span class="mdl-radio__label">{$i18n->getValueForRef('bazaar')}</span>
                </label>
            </div>
            <div class="mdl-cell mdl-cell--12-col nwep-components__options">
                {$i18n->getValueForRef('bazaar-discounts')} : 
                <label
                    class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect nwep-components__options__checkbox"
                    for="componentsOptionsDiscountEvent"
                >
                    <input
                        type="checkbox"
                        id="componentsOptionsDiscountEvent"
                        name="components[options][discount][event]"
                        value="enabled"
                        class="mdl-checkbox__input"
                        data-discount-type="event"
                        data-discount-vip-lvl=""
                    >
                    <span class="mdl-checkbox__label">{$i18n->getValueForRef('event-(-15%)')}</span>
                </label>
                {set $vipDiscountLvls = [8, 9, 10, 11, 12]}
                {foreach $vipDiscountLvls as $lvl}
                    <label
                        class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect nwep-components__options__checkbox"
                        for="componentsOptionsDiscountVIP{$lvl}"
                    >
                        <input
                            type="checkbox"
                            id="componentsOptionsDiscountVIP{$lvl}"
                            name="components[options][discount][vip][{$lvl}]"
                            value="enabled"
                            class="mdl-checkbox__input"
                            data-discount-type="vip"
                            data-discount-vip-lvl="{$lvl}"
                        >
                        {set $i18nVipDiscount = "vip-" ~ $lvl ~ "-(-5%)"}
                        <span class="mdl-checkbox__label">{$i18n->getValueForRef($i18nVipDiscount)}</span>
                    </label>
                {/foreach}
            </div>
            <table class="mdl-data-table mdl-js-data-table nwep-table">
                <thead>
                    <tr>
                        <th></th>
                        {foreach $componentList as $component}
                            <th
                                class="nwep-js-component-item"
                                data-component-id="{$component->idComponent}"
                            >
                                <img
                                    src="/assets/images/components/{$component->idComponent}.png"
                                    alt="{$i18n->getValueForId($component->idI18n)}"
                                    title="{$i18n->getValueForId($component->idI18n)}"
                                    class="nwep-components__image nwep-components__image--border-{$component->color}"
                                >
                            </th>
                        {/foreach}
                    </tr>
                </thead>
                <tbody>
                    {set $componentsPricesType = ['ah' => 'action-house', 'bazaar' => 'bazaar']}
                    {foreach $componentsPricesType as $compPriceTypeKey => $compPriceTypeName index=$compPriceIndex}
                        <tr>
                            <td>{$i18n->getValueForRef($compPriceTypeName)}</td>
                            {foreach $componentList as $component}
                                {set $rowspan = ''}
                                {if $component->intoBazaar == 0}
                                    {if $compPriceIndex === 1}
                                        <input
                                            type="hidden"
                                            id="componentsPrice[{$component->idComponent}][{$compPriceTypeKey}][raw]"
                                            value="{$component->priceAH}"
                                        >
                                        {continue}
                                    {else}
                                        {set $rowspan = 'rowspan="2"'}
                                    {/if}
                                {/if}
                                
                                <td
                                    class="nwep-components__item"
                                    {$rowspan}
                                >
                                    {if $compPriceTypeKey === 'ah'}
                                        {set $tokenName = 'components_' ~ $component->idComponent}
                                        {set $tokenValue = $tokens->newInput($tokenName)}
                                        <div class="mdl-textfield mdl-js-textfield nwep-textfield">
                                            <input
                                                type="hidden"
                                                id="componentsPrice[{$component->idComponent}][{$compPriceTypeKey}][raw]"
                                                value="{$component->priceAH}"
                                            >
                                            <input
                                                type="hidden"
                                                id="componentsPrice[{$component->idComponent}][token]"
                                                value="{$tokenValue}"
                                            >
                                            <input
                                                type="text"
                                                class="mdl-textfield__input nwep-textfield__input"
                                                id="componentsPrice[{$component->idComponent}][{$compPriceTypeKey}][formated]"
                                                value="{$component->priceAH|number_format}"
                                                data-component-price-from="{$compPriceTypeKey}"
                                            >
                                        </div>
                                    {elseif $compPriceTypeKey === 'bazaar'}
                                        <input
                                            type="hidden"
                                            id="componentsPrice[{$component->idComponent}][{$compPriceTypeKey}][raw]"
                                            value="{$component->priceBazaar}"
                                        >
                                        {$component->priceBazaar|number_format}
                                    {/if}
                                </td>
                            {/foreach}
                        </tr>
                    {/foreach}
                </tbody>
                <tfoot>
                    <tr>
                        <td>{$i18n->getValueForRef('used-price')}</td>
                        {foreach $componentList as $component}
                            <td data-component-id="{$component->idComponent}">
                                <input
                                    type="hidden"
                                    id="componentsPrice[{$component->idComponent}][raw]"
                                    value=""
                                >
                                <span class="components_final-price"></span>
                            </td>
                        {/foreach}
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

<script>
    nwep.components = {$componentList|json_encode};
</script>
