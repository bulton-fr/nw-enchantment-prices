<section
    id="ranksDetail"
    class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp nwep-layout__content__section"
>
    <div class="mdl-card mdl-cell mdl-cell--12-col">
        <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing nwep-card">
            <h2 class="mdl-cell mdl-cell--12-col mdl-typography--title nwep-card__title">
                {$i18n->getValueForRef('ranks-detail')}
            </h2>
            <table class="mdl-data-table mdl-js-data-table nwep-table">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">{$i18n->getValueForRef('name')}</th>
                        {foreach $componentList as $component}
                            <th>
                                <img
                                    src="/assets/images/components/{$component->idComponent}.png"
                                    alt="{$i18n->getValueForId($component->idI18n)}"
                                    class="nwep-components__image nwep-components__image--border-{$component->color}"
                                >
                            </th>
                        {/foreach}
                        <th>{$i18n->getValueForRef('price')}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $ranksDetails as $rankId => $rankInfo}
                        <tr
                            class="nwep-ranks__item"
                            data-rank-id="{$rankId}"
                            data-raw-price=""
                        >
                            <td class="mdl-data-table__cell--non-numeric">
                                {$i18n->getValueForId($rankInfo->idI18n)}
                            </td>
                            {foreach $rankInfo->components as $rankCompoNb}
                                {if $rankCompoNb > 0}
                                    <td>{$rankCompoNb|number_format}</td>
                                {else}
                                    <td>-</td>
                                {/if}
                            {/foreach}
                            <td></td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    nwep.ranksDetails = {$ranksDetails|json_encode};
</script>
