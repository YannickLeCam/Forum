<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    public function insertUser($data){
        return $this->add($data);
    }

    public function getUserByEmail($email){
        $sql = "
            SELECT *
            FROM user
            WHERE email = :email
        ";
        $params = [
            "email" => $email
        ];
        $user=DAO::select($sql,$params);
        if ($user) {
            return $user;
        }
        return null;
    }

    public function getUsers(){
        return $this->findAll();
    }
}