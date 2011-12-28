
<?php

class ResolutionComment extends Object {
    // any object specific code here relating to a single item
}

class ResolutionComments extends Table {
    protected $meta = array(
        'columns' => array(
            'content' => array(
                'title'    => 'Comment',
                'type'     => 'text',
            ),
            'parent_id' => array(
                'type' => 'foreign_key',
                'table' => 'Resolutions',
            ),
            'good' => array(
                'type' => 'number',
            ),
            'bad' => array(
                'type' => 'number',
            ),
        ),
    );
}
