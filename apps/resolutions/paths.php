<?php

PathManager::loadPaths(
    array("/(?P<year>\d{4})", "list_resolutions"),
    array("/new", "add_resolution")
);
