<?php

PathManager::loadPaths(
    array("/(?P<year>\d{4})", "list_resolutions"),
    array("/resolutions/new", "add_resolution"),
    array("/resolutions/(?P<resolution_id>\d+)/(?P<type>(good|bad))", "add_comment"),
    array("/resolutions/(?P<resolution_id>\d+)", "view_resolution"),
    array(
        "pattern" => "/resolutions/(?P<resolution_id>\d+)/(?P<type>(good|bad))/update",
        "action"  => "update_comment",
        "method"  => "POST",
    )
);
