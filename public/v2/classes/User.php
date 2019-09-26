<?php

class User {

    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn,
            $_cookieName;

    public function __construct($user = NULL) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    // process ogout
                }
            }
        } else {
            $this->find($user);
        }
    }
    
    public function update($fields = array(), $id = NULL) {
        
        if(!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }
        
        if(!$this->_db->update('users', $id, $fields)) {
            throw new Exception('Има проблем при изпълняването на заявката!');
        }
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('Възникна проблем при регистрацията, моля опитаите по късно!.');
        }
    }

    public function find($user = null) {
        if ($user) {
            $field = is_numeric($user) ? 'id' : 'username';
            if(empty($sort)){
                $sort = 'id ASC';
            }
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return TRUE;
            }
        }

        return FALSE;
    }

    public function login($username = null, $password = null, $remember = FALSE) {

        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);


            if ($user) {
                if ($this->data()->password === utf8_decode(Hash::make($password, $this->data()->salt))) {
                    Session::put($this->_sessionName, $this->data()->id);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return FALSE;
    }
    
    public function hasPermission($key){
        $group = $this->_db->get('groups', array('id', '=', $this->data()->groups));
        if($group->count()) {
            $permissions = json_decode($group->first()->permissions, true);
            if(isset($permissions[$key]) == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : FALSE;
    }

    public function data() {
        return $this->_data;
    }

    public function logout() {
        
        
       $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
        
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

}
