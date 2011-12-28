{extends 'default/views/base.tpl'}
{block name='title'}{$smarty.block.parent} - Resolutions{/block}
{block name='body'}
    <h1>Great stuff!</h1>
    <p><b>You did good!</b>. You've automatically logged a <b>+1</b> against this resolution. If you want, you can
    change this from between 1 and 10 using the slider below. If you want to explain (to yourself &ndash; or others)
    why you've logged this rating, you can do that too.</p>

    <form action='{$current_url}' method='post'>
        <input name='comment_id' type='hidden' value='{$comment->getId()}' />
        <input name='value' type='text' value='1' />
        <input name='comment' type='text' />
        <input type='submit' value='Update Entry' />
    </form>
{/block}
