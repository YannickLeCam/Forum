<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity{

    private $id;
    private $nickName;
    private $email;
    private $role;

    private $password;


    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

     /**
     * Get the value of id
     */ 
    public function getPassword(){
        return $this->password;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setPassword($password){
        $this->password = $password;
        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(){
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email){
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role){
        $this->role= $role;

        return $this;
    }

    /**
     * Get the value of role
     *
     */ 
    public function getRole(){
        return $this->role;
    }

    /**
     * Get the value of nickName
     */ 
    public function getNickName(){
        return $this->nickName;
    }

    /**
     * The function return a bool, verify if user is the role put in params.
     * 
     * string $role = role wanted to verify
     * 
     * return = bool
     */
    public function  hasRole(string $role):bool{
        if (str_contains($role,'ADMIN')) {
            if ($this->role == "ADMIN") {
                return true;
            }else {
                return false;
            }
        }
        if (str_contains($role,'USER')) {
            if ($this->role == "USER") {
                return true;
            }else {
                return false;
            }
        }else{
            return false;
        }
    }


    /**
     * Set the value of nickName
     *
     * @return  self
     */ 
    public function setNickName($nickName){
        $this->nickName = $nickName;

        return $this;
    }

    public function __toString() {
        return $this->nickName;
    }
}