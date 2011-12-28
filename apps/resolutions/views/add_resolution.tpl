{extends 'default/views/base.tpl'}
{block name='body'}
    <form action='{$current_url}' method='post'>
        {include file='default/views/helpers/field.tpl' field='content'}
        {include file='default/views/helpers/field.tpl' field='due_date' placeholder='2012'}
        <input type='submit' value='Add Resolution' />
    </form>
{/block}
