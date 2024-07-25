<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql ="
            SELECT t.*
            FROM topic t
            JOIN post p ON t.id_topic = p.topic_id
            WHERE t.category_id = :id
            AND p.creationDate = (
                SELECT MAX(p2.creationDate)
                FROM post p2
                WHERE p2.topic_id = t.id_topic
            )
            ORDER BY p.creationDate DESC;
        ";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function findTopicsByIdUser($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE user_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }
    /**
     * This function return one Topic List instance where name $contain 
     * 
     * @param string $contain filtered
     * 
     * @return array[Topic] or null 
     */
    public function researchTopics($contain){
        $contain = '%'.$contain.'%';
        $sql = "
            SELECT *
            FROM topic
            WHERE title LIKE :contain;
        ";
        $params = [
            "contain"=>$contain
        ];
        return $this->getMultipleResults(
            DAO::select($sql,$params),
            $this->className
        );
    }

    public function nbPostInTopic(int $id):int{
        $sql = "
            SELECT COUNT(id_post) AS nbPosts
            FROM post
            WHERE topic_id = :id;
        ";
        $params = [
            "id"=>$id
        ];
        $select = DAO::select($sql,$params,false);
        return $select['nbPosts'];
    }
    
    public function lastPost($id){
        $sql = "
            SELECT id_post
            FROM post p
            WHERE topic_id = :id
            ORDER BY creationDate DESC
            LIMIT 1;
        ";
        $params = [
            "id" =>$id
        ];

        $select=DAO::select($sql,$params,false);
        
        if ($select) {
            $postManager = new PostManager();
            return $postManager->findOneById($select['id_post']);
        }else {
            return null;
        }
    }

    public function insertTopic($data){
        return $this->add($data);
    }
}