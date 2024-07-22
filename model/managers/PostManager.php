<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    public function __construct(){
        parent::connect();
    }

    public function findPostsByTopic($id,$page) {
        if ($page==null) {
            $page=1;
        }
        $offset = ($page-1) * 5;
        $sql = "SELECT * 
                FROM ".$this->tableName." p 
                WHERE p.topic_id = :id
                LIMIT 5 OFFSET ". $offset;
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, [
                'id' => $id
            ]), 
            $this->className
        );
    }

    
    public function findPostsByIdUser($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.user_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function updateMessage($data){
        $sql = "
            UPDATE post
            SET message = :message
            WHERE id_post = :id;
        ";

        return DAO::update($sql,$data);
    }


    public function insertData(array $data){
        return $this->add($data);
    }
}