<?php

PathManager::loadPaths(
    array("/(?P<year>\d{4})", "list_resolutions"),
    array("/(?P<year>\d{4})/new", "add_resolution")
);
