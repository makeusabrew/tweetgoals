<?php

PathManager::loadPaths(
    array("/(?P<year>\d{4})", "list_resolutions"),
    array("/resolutions/new", "add_resolution"),
    array("/resolutions/(?P<resolution_id>\d+)/good", "add_good_comment"),
    array("/resolutions/(?P<resolution_id>\d+)/bad", "add_bad_comment")
);
