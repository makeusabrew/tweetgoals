{extends file='default/views/base.tpl'}
{block name='title'}{$smarty.block.parent} - Resolutions{/block}
{block name='body'}
    {foreach from=$resolutions item='resolution'}
        <div>
            {$resolution->content|htmlentities8}
            <div>
                <a href='/resolutions/{$resolution->getId()}/good'>Did good :)</a>
                <a href='/resolutions/{$resolution->getId()}/bad'>Did bad :(</a>
            </div>
        </div>
    {/foreach}
{/block}
