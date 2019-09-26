<?php

class DB {

    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_results_assoc,
            $_resultsAll,
            $_count = 0,
            $_countLoop = 0;

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {  //nepozvolqva poveche ot edna conekciq zatova const. e private
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()) {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->_query->execute()) { // sledkato mine conekciqta se sluchva tazi stypka
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    private function action($action, $table, $where = array(), $sort = NULL) {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            
//            if(empty($sort)){
//                $sort = 'id ASC';
//            }
            
            
            if (in_array($operator, $operators)) {
                if(!empty($sort)){
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ORDER BY {$sort}";
                } else {
                     $sql = "{$action} FROM {$table} WHERE {$field} {$operator}";
                }
                
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }

        return FALSE;
    }

    public function actionLoop($action, $table, $where = array()) {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
           
            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ";
                
                if (!$this->query($sql, array($value))->error()) {
                    if ($this->_query->execute()) {
                        $this->_resultsAll = $this->_query->fetchAll(PDO::FETCH_OBJ);
                        $this->_countLoop = $this->_query->rowCount();
                    } else {
                        $this->_error = TRUE;
                    }
                }
                return TRUE;
            }
        }
    }

    private function actionAll($action, $table) {

        $sql = "{$action} FROM {$table} ORDER BY id ASC";

        if ($this->_query = $this->_pdo->query($sql)) {

            if ($this->_query->execute()) { // sledkato mine conekciqta se sluchva tazi stypka
                $this->_resultsAll = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
            return TRUE;
        }
        return FALSE;
    }

    private function search($action, $table, $where = array(), $sort = NULL) {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            
            if(empty($sort)){
                $sort = 'id ASC';
            }

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} LIKE ? ORDER BY {$sort}";

                if (!$this->query($sql, array('%' . $value . '%'))->error()) {
                    return $this;
                }
            }
        }

        return FALSE;
    }

    public function get_search($table, $where, $sort = NULL) {
        return $this->search('SELECT *', $table, $where, $sort);
    }

    public function get($table, $where, $sort = NULL) {
        if(empty($sort)){
                $sort = 'id ASC';
            }
        return $this->action('SELECT *', $table, $where, $sort);
    }

    public function getLoop($table, $where) {
        return $this->actionLoop('SELECT *', $table, $where);
    }

    public function getAll($table) {
        return $this->actionAll('SELECT *', $table);
    }

    public function delete($table, $where) {
        $sql = "DELETE FROM {$table} WHERE {$where}";

        if (!$this->query($sql)->error()) {
            return true;
        }
        
        return FALSE;
    }

    public function insert($table, $fields = array()) {
        $keys = array_keys($fields);
        $values = NULL;
        $x = 1;

        foreach ($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return FALSE;
    }

    public function update($table, $id, $fields) {
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";

            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return FALSE;
    }

    public function results() {
        return $this->_results;
    }

    public function fetch() {
        return $this->results();
    }

    public function first() {
        return $this->results()[0];
    }

    public function resultAll() {
        return $this->_resultsAll;
    }

    public function error() {
        return $this->_error;
    }

    public function count() { // izkarva rezultata
        return $this->_count;
    }
    
    public function countLoop(){
        return $this->_countLoop;
    }

}
