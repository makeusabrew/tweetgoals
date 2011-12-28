<?php

require_once('apps/default/controllers/abstract.php');
class ResolutionsController extends AbstractController {
    public function add_resolution() {
        $this->assign('columns', Table::factory('Resolutions')->getColumns());
        if ($this->request->isPost()) {
            $data = array(
                'content' => $this->request->getVar('content'),
                'due_date' => '31/12/2012', // @todo ... yeah
                'user_id' => $this->user->getId(),
                'sort_order' => Table::factory('Resolutions')->getNextSortOrder()
            );
            $resolution = Table::factory('Resolutions')->newObject();
            if ($resolution->setValues($data)) {
                $resolution->save();
                return $this->redirect(array(
                    'action' => 'list_resolutions',
                    'year' => 2012,
                ));
            }
            $this->setErrors(
                $resolution->getErrors()
            );
        }
    }

    public function list_resolutions() {
        $this->assign('resolutions', Table::factory('Resolutions')->findForUser($this->user->getId()));
    }

    public function add_good_comment() {
        $comment = Table::factory('ResolutionComments')->newObject();
        $comment->setValues(array(
            'parent_id' => $this->getMatch('resolution_id'),
            'good' => 1,
        ));
        $comment->save();
        $this->assign('comment', $comment);
    }
}
