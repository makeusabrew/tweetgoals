{extends file="base.tpl"}
{block name="body"}
    <h1>TNYR</h1>
{if $user->isAuthed()}
    <a href="/resolutions/new">Add resolution</a>
{/if}
{/block}
