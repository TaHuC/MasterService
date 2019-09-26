<?php

class Search {

    public $_db,
           $_data;

    public function __construct($search = NULL) {
        
        $this->_db = DB::getInstance();
        
        return $this->_db;
    }

    public function result($search = NULL) {
        if ($search) {
            $field = 'email';
            $this->_db->get('clients', array($field, '=', $search));
            exit();
        }

        return FALSE;
    }

}
