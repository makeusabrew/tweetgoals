<?php

require_once('apps/default/controllers/abstract.php');
class ResolutionsController extends AbstractController {
    public function add_resolution() {
        //
        $this->assign('columns', Table::factory('Resolutions')->getColumns());
    }

    public function list_resolutions() {
        $this->assign('resolutions', Table::factory('Resolutions')->findForUser($this->user->getId()));
    }
}
