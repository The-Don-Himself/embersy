<?php

namespace AppBundle\JsonApi;

class Accounts
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
            if($key == "id") {
                $this->$key = 'me';
            } else {
                $this->$key = $value;
            }
        }
    }

}
