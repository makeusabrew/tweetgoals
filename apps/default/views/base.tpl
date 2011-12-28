<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{block name='title'}{setting value="site.title"}{/block}</title>
    {include file='default/views/helpers/google_analytics.tpl'}
</head>
<body>
    {if isset($messages) && count($messages)}
        <div id='messageOuter'>
            {foreach from=$messages item="message"}
                <div class='message'>
                    {$message}
                </div>
            {/foreach}
        </div>
    {/if}
    <ul id="nav">
        <li><a href="/">home</a></li>
        {if $user->isAuthed()}
            <li><a href="/me">settings</a></li>
        {else}
            <li><a href="/login">login</a></li>
        {/if}
    </ul>
    {block name="body"}
        <p>Your body content goes here. This block will be automatically
        overridden when you extend this base template and re-declare
        this block.</p>
    {/block}

    {*
      ordinarily body will probably be wrapped with surrounding markup, so it
      makes sense to have a separate block to put script tags in
     *}
    {block name="script"}{/block}
</body>
</html>
