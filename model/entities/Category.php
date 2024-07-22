<?php
namespace Model\Entities;

use App\DAO;
use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Category extends Entity{

    private $id;
    private $name;
    private $nbTopics;
    private $nbPosts;
    private $dernierTopicEdit;

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){         
        $this->hydrate($data); 
        $this->setNbTopics();
        $this->setNbPosts();
    }

    public function setNbPosts(){
        $sql = "
            SELECT COUNT(id_post) AS NbPosts
            FROM topic
            JOIN post
            ON post.topic_id = topic.id_topic
            WHERE category_id = :id;
        ";
        $params = [
            "id"=>$this->id,
        ];
        $select=DAO::select($sql,$params,false);
        $this->nbPosts = $select['NbPosts'];
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

    public function setNbTopics(){
        $sql = "
            SELECT COUNT(id_topic) AS NbTopics
            FROM topic
            WHERE category_id = :id;
        ";
        $params = [
            "id"=>$this->id,
        ];
        $select=DAO::select($sql,$params,false);
        $this->nbTopics = $select['NbTopics'];
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