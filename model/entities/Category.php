<?php
namespace Model\Entities;

use App\DAO;
use App\Entity;
use Model\Managers\CategoryManager;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Category extends Entity{

    private $id;
    private $name;
    private $nbTopics;
    private $nbPosts;

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){ 
        $this->hydrate($data);
    }


    public function setNbPosts($nbPosts){
        $this->nbPosts = $nbPosts;
        return $this;
    }

    public function getNbPosts(){
        return $this->nbPosts;
    }

    /**
     * Get the value of NbTopics
     */ 
    public function getNbTopics(){
        return $this->nbTopics;
    }

    public function setNbTopics($nbTopics){
        $this->nbTopics=$nbTopics;
        return $this;
    }
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName(){
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function __toString(){
        return $this->name;
    }
}