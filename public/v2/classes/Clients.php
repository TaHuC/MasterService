<?php

class Clients {

    private $_db,
            $_data,
            $_dataPagination,
            $_search,
            $_num,
            $_numLoop;

    public function __construct($client = NULL) {
        $this->_db = DB::getInstance();
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('clients', $fields)) {
            throw new Exception('<h1>И аз незнам какво стана са!!!</h1>');
        }
    }
    
    public function findOne($client = NULL, $type = null, $table = NULL, $sort = NULL) {
        if ($client) {

            if (empty($sort)) {
                $sort = 'id ASC';
            }

            $data = $this->_db->get($table, array($type, '=', $client), $sort);

            if ($data->count()) {
                $this->_data = $data->first();
                $this->_num = $data->count();
                return TRUE;
            }
        }
        return false;
    }

    public function find($client = NULL, $type = null, $table = NULL, $sort = NULL) {
        if ($client) {

            if(empty($sort)){
                $sort = 'id ASC'; 
             }
             
            $data = $this->_db->get_search($table, array($type, '=', $client), $sort);
            
            if ($data->count()) {
                $this->_search = $data->fetch();
                $this->_data = $data->first();
                $this->_num = $data->count();
                return TRUE;
            }
        }
        return false;
    }
    
    public function findAll($table = NULL) {
        if ($table) {

            $this->_db->getAll($table);

            if ($this->_db->count()) {
                $this->_data = $this->_db->resultAll();
                $this->_num = $this->_db->countNum();
                return TRUE;
            }
        }
        return false;
    }

    public function findPagination($table = NULL, $limit, $end) {
        if ($table) {

           $this->_db->getPagination($table, $limit, $end);

            if ($this->_db->count()) {
                $this->_dataPagination = $this->_db->resultPagination();
                $this->_num = $this->_db->count();

                return TRUE;
            }
        }
        return false;
    }
    
    public function findLoop($client = NULL, $type = NULL, $table = NULL){
        if($client){
            $data = $this->_db->getLoop($table, array($type, '=', $client));
            
            if($this->_db->count()) {
                $this->_data = $this->_db->resultAll();
                $this->_numLoop = $this->_db->countLoop();
                return TRUE;
            }
        }
    }

   

        public function data(){
        return $this->_data;
    }

    public function dataPagination(){
        return $this->_dataPagination;
    }
    
    public function search(){
        return $this->_search;
    }

    public function numres() {
        return $this->_num;
    }
    
    public function numersLoop() {
        return $this->_numLoop;
    }

}
