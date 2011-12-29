{extends 'default/views/base.tpl'}
{block name='body'}
    <h1>{$resolution->content|htmlentities8}</h1>
    <ul>
        {foreach from=$updates item="update"}
            <li>
                {$update->created}
                {$update->getValueString()}
                {$update->content|htmlentities8}
            </li>
        {/foreach}
    </ul>
{/block}
