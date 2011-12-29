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

        $update = Table::factory('ResolutionUpdates')->newObject();
        $update->setValues($data);
        $update->save();
        $this->assign('update', $update);
        $this->assign('type', $this->getMatch('type'));
    }

    public function update_comment() {
        $idx = $this->getMatch('type');
        $update = Table::factory('ResolutionUpdates')->findByIdForUser(
            $this->request->getVar('update_id'),
            $this->user->getId()
        );

        if (!$update) {
            // bad luck
            die("no update");
        }

        if (Utils::olderThan(300, $update->created)) {
            die("too old");
        }

        $data = array(
            $idx      => $this->request->getVar('value'),
            'content' => $this->request->getVar('comment')
        );

        if ($update->updateValues($data, true)) {
            $update->save();
            return $this->redirect("/");
        }
        $this->setErrors(
            $update->getErrors()
        );
    }

    public function view_resolution() {
        $resolution = Table::factory('Resolutions')->read($this->getMatch('resolution_id'));
        if (!$resolution) {
            die("no resolution");
        }
        $this->assign('resolution', $resolution);
        $this->assign('updates', $resolution->getUpdates());
    }
}
