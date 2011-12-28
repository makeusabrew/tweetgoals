<?php

class Resolution extends Object {
    // any object specific code here relating to a single item
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

    public function findForUser($user_id) {
        return $this->findAll(array(
            'user_id' => $user_id,
        ));
    }

    public function getNextSortOrder() {
        $highest = $this->find(null, null, "sort_order DESC");
        return $highest ? $highest->sort_order + 1 : 0;
    }
}
