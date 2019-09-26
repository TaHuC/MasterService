<?php

/**
 * Description of ADD
 *
 * @author tahuc
 */
class ADD {

    private $_data,
            $_db,
            $_search,
            $_num,
            $_numLoop;

    public function __construct($add = NULL) {
        $this->_db = DB::getInstance();
    }

    public function create($fields = array(), $table = NULL) {
        if (!$this->_db->insert($table, $fields)) {
            throw new Exception('<h1>Има някакъв проблем, моля да опитате по късно</h1>');
        }
    }

    public function update($fields = array(), $id = NULL, $table = NULL) {

        if (!$this->_db->update($table, $id, $fields)) {
            throw new Exception('Има проблем при изпълняването на заявката!');
        }
    }
    
    public function dell($table = NULL, $value = NULL){
        $this->_db->delete($table, $value);
    }

    public function find($client = NULL, $type = null, $table = NULL, $sort = NULL) {
        if ($client) {

            if (empty($sort)) {
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

    public function findAll($table = NULL) {
        if ($table) {

            $data = $this->_db->getAll($table);

            if ($this->_db->count()) {
                $this->_data = $this->_db->resultAll();
                $this->_num = $this->_db->count();
                return TRUE;
            }
        }
        return false;
    }

    public function data() {
        return $this->_data;
    }

    public function search() {
        return $this->_search;
    }

    public function numres() {
        return $this->_num;
    }

    public function numersLoop() {
        return $this->_numLoop;
    }

}
