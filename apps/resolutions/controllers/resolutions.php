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
        $this->assign('resolutions', Table::factory('Resolutions')->findAllForUser($this->user->getId()));
    }

    public function add_comment() {
        $idx = $this->getMatch('type');
        $data = array(
            'parent_id' => $this->getMatch('resolution_id'),
            $idx => 1,
        );

        $comment = Table::factory('ResolutionComments')->newObject();
        $comment->setValues($data);
        $comment->save();
        $this->assign('comment', $comment);
        $this->assign('type', $this->getMatch('type'));
    }

    public function update_comment() {
        $idx = $this->getMatch('type');
        $comment = Table::factory('ResolutionComments')->findByIdForUser(
            $this->request->getVar('comment_id'),
            $this->user->getId()
        );

        if (!$comment) {
            // bad luck
            die("no comment");
        }

        if (Utils::olderThan(300, $comment->created)) {
            die("too old");
        }

        $data = array(
            $idx      => $this->request->getVar('value'),
            'content' => $this->request->getVar('comment')
        );

        if ($comment->updateValues($data, true)) {
            $comment->save();
            return $this->redirect("/");
        }
        $this->setErrors(
            $comment->getErrors()
        );
    }
}
