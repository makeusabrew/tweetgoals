<div>
    {$resolution->content|htmlentities8}
    {$resolution->getGoodString()} / 
    {$resolution->getBadString()}
    <div>
        <a href='/resolutions/{$resolution->getId()}/good'>Did good :)</a>
        <a href='/resolutions/{$resolution->getId()}/bad'>Did bad :(</a>
        <a href='/resolutions/{$resolution->getId()}'>View</a>
    </div>
</div>
