{extends file="base.tpl"}
{block name="body"}
    <h1>TNYR</h1>
{if $user->isAuthed()}
    <a href="/new">Add resolution</a>
    My list here
{/if}
{/block}
