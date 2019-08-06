<?php
namespace zoge\barion\models;

use zoge\barion\models\UserNameModel;

use zoge\barion\helpers\iBarionModel;

class UserModel implements iBarionModel
{
    public $Name;
    public $Email;
    
    function __construct() {
        $this->Name = "";
        $this->Email = "";
    }

    function fromJson($json)
    {
        if (!empty($json)) {
            $this->Email = $json['Email'];

            $name = new UserNameModel();
            $name->fromJson($json['Name']);
        }
    }
}

?>