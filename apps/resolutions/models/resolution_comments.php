
<?php

class ResolutionComment extends Object {
    // any object specific code here relating to a single item
    public function getValueString() {
        if ($this->good > 0) {
            return "+".$this->good;
        }
        return "-".$this->bad;
    }
}

class ResolutionComments extends Table {
    protected $order_by = 'created ASC';
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

    public function findByIdForUser($id, $user_id) {
        $sql = "SELECT  rc.* FROM `resolution_comments` rc
            INNER JOIN (`resolutions` r) ON (rc.parent_id=r.id)
            WHERE rc.id = ? AND r.user_id = ?";

        $params = array($id, $user_id);

        $dbh = Db::getInstance();
        $sth = $dbh->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_CLASS, "ResolutionComment");
        $sth->execute($params);
        return $sth->fetch();
    }
}
