<?php

namespace AppBundle\JsonApi;

class User
{
    public $id;
    public $username;
    public $enabled;
    public $lastlogin;

    public function __construct(Array $array)
    {
        foreach($array as $key => $value){
            if($key == "last_login") {
                $this->lastlogin = $value;
            } elseif($key == "email") {

            } elseif($key == "roles") {

            } else {
                $this->$key = $value;
            }
        }
    }

}
