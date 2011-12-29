<?php
require_once('apps/default/controllers/abstract.php');
class DefaultController extends AbstractController {
    public function index() {
        $this->assign('resolutions', Table::factory('Resolutions')->findAllForUser($this->user->getId()));
    }
}
