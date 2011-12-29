{extends file="base.tpl"}
{block name="body"}
    <h1>TNYR</h1>
{if $user->isAuthed()}
    <a href="/resolutions/new">Add resolution</a>
    {foreach from=$resolutions item="resolution"}
        {include file='resolutions/views/partials/resolution.tpl'}
    {/foreach}
{/if}
{/block}
