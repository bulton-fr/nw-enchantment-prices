<section
    id="componentsPrices"
    class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp nwep-layout__content__section"
>
    <div class="mdl-card mdl-cell mdl-cell--12-col">
        <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing nwep-card">
            <h2 class="mdl-cell mdl-cell--12-col mdl-typography--title nwep-card__title">
                Components prices
            </h2>
            <table class="mdl-data-table mdl-js-data-table nwep-table">
                <thead>
                    <tr>
                        {foreach $componentList as $component}
                            <th>
                                <img
                                    src="/assets/images/components/{$component->idComponent}.png"
                                    alt="{$i18n->getValueForId($component->idI18n)}"
                                    class="nwep-components__image nwep-components__image--border-{$component->color}"
                                >
                            </th>
                        {/foreach}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        {foreach $componentList as $component}
                            <td
                                class="nwep-components__item"
                                data-component-id="{$component->idComponent}"
                            >
                                <div class="mdl-textfield mdl-js-textfield nwep-textfield">
                                    <input
                                        type="hidden"
                                        id="componentsPrice[{$component->idComponent}][raw]"
                                        value="{$component->price}"
                                    >
                                    <input
                                        type="text"
                                        class="mdl-textfield__input nwep-textfield__input"
                                        id="componentsPrice[{$component->idComponent}][formated]"
                                        value="{$component->price|number_format}"
                                    >
                                </div>
                            </td>
                        {/foreach}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    nwep.components = {$componentList|json_encode};
</script>
