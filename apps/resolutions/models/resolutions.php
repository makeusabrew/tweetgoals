<?php

class Resolution extends Object {
    protected $updates = null;

    public function getUpdates() {
        if ($this->updates === null) {
            $this->updates = Table::factory('ResolutionUpdates')->findAll(array(
                'parent_id' => $this->getId(),
            ));
        }
        return $this->updates;
    }

    public function getGoodString() {
        $comments = $this->getUpdates();
        $value = 0;
        foreach ($comments as $comment) {
            if ($comment->good > 0) {
                $value += $comment->good;
            }
        }
        return $value ? "+".$value : "0";
    }

    public function getBadString() {
        $comments = $this->getUpdates();
        $value = 0;
        foreach ($comments as $comment) {
            if ($comment->bad > 0) {
                $value += $comment->bad;
            }
        }
        return $value ? "-".$value : "0";
    }
}

class Resolutions extends Table {
    protected $order_by = 'sort_order ASC';
    protected $meta = array(
        'columns' => array(
            'content' => array(
                'title'    => 'Resolution',
                'type'     => 'text',
                'required' => true,
            ),
            'user_id' => array(
                'type' => 'foreign_key',
                'table' => 'Users',
            ),
            'due_date' => array(
                'title' => 'Due Date',
                'type' => 'date',
            ),
            'done' => array(
                'type' => 'bool',
            ),
            'sort_order' => array(
                'type' => 'number',
                'validation' => 'unsigned',
            ),
        ),
    );

    public function findAllForUser($user_id) {
        return $this->findAll(array(
            'user_id' => $user_id,
        ));
    }

    public function getNextSortOrder() {
        $highest = $this->find(null, null, "sort_order DESC");
        return $highest ? $highest->sort_order + 1 : 0;
    }
}
