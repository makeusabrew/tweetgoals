{extends 'base.tpl'}
{block name='body'}
    {foreach from=$resolutions item='resolution'}
        {$resolution->content}
    {/foreach}
{/block}
