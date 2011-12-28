<?php

class Resolution extends Object {
    // any object specific code here relating to a single item
}

class Resolutions extends Table {
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
        ),
    );
}
