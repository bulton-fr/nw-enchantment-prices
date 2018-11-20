<section
    id="{$type}Enchantment"
    class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp nwep-layout__content__section"
>
    <div class="mdl-card mdl-cell mdl-cell--12-col">
        <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing nwep-card">
            <h2 class="mdl-cell mdl-cell--12-col mdl-typography--title nwep-card__title nwep-enchantments">
                {$type} enchantments
            </h2>
            {set $list = $enchantmentList.$type}

            {foreach $list as $enchantId => $enchant}
                <div
                    class="nwep-enchantments__item"
                    data-enchant-type="{$type}"
                    data-enchant-id="{$enchantId}"
                >
                    <h3
                        class="mdl-typography--title"
                        id="{$i18n->getValueForId($enchant->idI18n)}"
                    >
                        <img
                            src="/assets/images/enchantments/{$enchantId}.png"
                            class="nwep-enchantments__image"
                        > 
                        {$i18n->getValueForId($enchant->idI18n)}
                    </h3>

                    <table class="mdl-data-table mdl-js-data-table nwep-table">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">Name</th> <!-- i18n -->
                                {foreach $enchant->ranks as $rankInfo}
                                    <th class="mdl-data-table__cell--non-numeric">
                                        {$i18n->getValueForId($rankInfo->idI18n)}
                                    </th>
                                {/foreach}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="mdl-data-table__cell--non-numeric">Upgrade</td>
                                {foreach $enchant->ranks as $rankId => $rankInfo}
                                    <td>
                                        <span
                                            id="enchantmentPrices[upgrade][{$enchantId}][{$rankId}]"
                                            data-raw-value=""
                                        ></span>
                                    </td>
                                {/foreach}
                            </tr>
                            <tr>
                                <td class="mdl-data-table__cell--non-numeric">Action house</td>
                                {foreach $enchant->ranks as $rankId => $rankInfo}
                                    {set $rankPriceFormated = $rankInfo->price}
                                    {if $rankInfo->price > 0}
                                        {set $rankPriceFormated = $rankInfo->price|number_format}
                                    {else}
                                        {set $rankPriceFormated = ''}
                                    {/if}
                                    
                                    {set $tokenName = 'enchants_' ~ $enchantId ~ '_' ~ $rankId}
                                    {set $tokenValue = $tokens->newInput($tokenName)}
                                    <td>
                                        <div class="mdl-textfield mdl-js-textfield nwep-textfield">
                                            <input
                                                type="hidden"
                                                id="enchantmentPrices[ah][raw][{$enchantId}][{$rankId}]"
                                                value="{$rankInfo->price}"
                                            >
                                            <input
                                                type="hidden"
                                                id="enchantmentPrices[token][{$enchantId}][{$rankId}]"
                                                value="{$tokenValue}"
                                            >
                                            <input
                                                type="text"
                                                class="mdl-textfield__input nwep-textfield__input"
                                                id="enchantmentPrices[ah][formated][{$enchantId}][{$rankId}]"
                                                value="{$rankPriceFormated}"
                                                data-rank-id="{$rankId}"
                                            >
                                            <label
                                                class="mdl-textfield__label"
                                                for="enchantmentPrices[{$enchantId}][{$rankId}]"
                                            >
                                                AH price
                                            </label>
                                        </div>
                                    </td>
                                {/foreach}
                            </tr>
                        </tbody>
                    </table>
                    <script>
                        nwep.enchantments.{$type}[{$enchantId}] = {$enchant|json_encode};
                    </script>
                </div>
            {/foreach}
        </div>
    </div>
</section>