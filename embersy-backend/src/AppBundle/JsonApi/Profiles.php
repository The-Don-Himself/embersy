<?php

namespace AppBundle\JsonApi;

use AppBundle\JsonApi\User;

class Profiles
{
    public $id; 
    public $user = array();
    public $joined; 
    public $firstname; 
    public $lastname; 
    public $avatarversion; 
    public $status; 

    public function __construct(Array $array)
    {
        foreach($array as $key => $value){
            if($key == "user" && isset($value['id'])) {
                $this->$key = new User($value);
            } else {
                $this->$key = $value;
            }
        }
    }

}
