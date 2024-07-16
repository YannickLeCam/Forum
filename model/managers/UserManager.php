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
            ":email" => $email
        ];

        return $this->getOneOrNullResult(
            DAO::select($sql, $params, false), 
            $this->className
        );
    }

    public function editPseudo($newPseudo , $id){
        $sql = "
            UPDATE user
            SET nickName = :nickName
            WHERE id_user = :id;
        ";
        $params=[
            "nickName"=>$newPseudo,
            "id"=>$id
        ];
        
        return DAO::update($sql,$params);
    }
    
    public function editPassword($newPassword , $id){
        $sql = "
            UPDATE user
            SET password = :password
            WHERE id_user = :id;
        ";
        $params=[
            "password"=>$newPassword,
            "id"=>$id
        ];
        
        return DAO::update($sql,$params);
    }


    public function getUsers(){
        return $this->findAll();
    }
}