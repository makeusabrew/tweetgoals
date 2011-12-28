{extends file='default/views/base.tpl'}
{block name='title'}{$smarty.block.parent} - Resolutions{/block}
{block name='body'}
    <h1>Welcome to your new application!</h1>
    <p>You've created a new application which can be found in <code>/var/www/nick/tnyr/apps/resolutions</code>.</p>

    <p>Your application has been created with a basic controller with one action (this one). It
    can be found at <code>/var/www/nick/tnyr/apps/resolutions/controllers/resolutions.php</code>.</p>

    <p>You can edit this template at <code>/var/www/nick/tnyr/apps/resolutions/views/index.tpl</code>.</p>

    <p>You can add, edit and remove this path from the paths file located at <code>/var/www/nick/tnyr/apps/resolutions/paths.php</code>.</p>

    <p>Your application also has a basic model which can
    be found at <code>/var/www/nick/tnyr/apps/resolutions/models/resolutions.php</code>.</p>{/block}
