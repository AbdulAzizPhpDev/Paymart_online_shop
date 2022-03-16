<div class="table-responsive-wrapper longtap-selection">
    <table class="table table-middle table--relative table-responsive">
        <thead
                data-ca-bulkedit-default-object="true"
                data-ca-bulkedit-component="defaultObject"
        >
        <tr>
            <th width="6%" class="left mobile-hide">
                {include file="common/check_items.tpl" is_check_disabled=!$has_permission check_statuses=($has_permission) ? $banner_statuses : '' }

                <input type="checkbox"
                       class="bulkedit-toggler hide"
                       data-ca-bulkedit-disable="[data-ca-bulkedit-default-object=true]"
                       data-ca-bulkedit-enable="[data-ca-bulkedit-expanded-object=true]"
                />
            </th>
            <th><a class="cm-ajax" href="{"`$c_url`&sort_by=name&sort_order=`$search.sort_order_rev`"|fn_url}"
                   data-ca-target-id={$rev}>{__("banner")}{if $search.sort_by === "name"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
            </th>
            <th width="10%" class="mobile-hide"><a class="cm-ajax"
                                                   href="{"`$c_url`&sort_by=type&sort_order=`$search.sort_order_rev`"|fn_url}"
                                                   data-ca-target-id={$rev}>{__("type")}{if $search.sort_by === "type"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
            </th>
            <th width="15%"><a class="cm-ajax"
                               href="{"`$c_url`&sort_by=timestamp&sort_order=`$search.sort_order_rev`"|fn_url}"
                               data-ca-target-id={$rev}>{__("creation_date")}{if $search.sort_by === "timestamp"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
            </th>

            {hook name="banners:manage_header"}
            {/hook}

            <th width="6%" class="mobile-hide">&nbsp;</th>
            <th width="10%" class="right"><a class="cm-ajax"
                                             href="{"`$c_url`&sort_by=status&sort_order=`$search.sort_order_rev`"|fn_url}"
                                             data-ca-target-id={$rev}>{__("status")}{if $search.sort_by === "status"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
            </th>
        </tr>
        </thead>
        {foreach from=$paymart_orders item=banner}
            <tr>{($banner->products[0]->name)}</tr>
            <br>
        {/foreach}
    </table>
</div>