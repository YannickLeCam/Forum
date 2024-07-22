<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;
use Model\Entities\Topic;

class CategoryManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct(){
        parent::connect();
    }


    /**
     * This function return one Category list instance where name $contain 
     * 
     * @param string $contain filtered
     * 
     * @return array[Category] or null 
     */
    public function researchCategories(string $contain){
        $contain = '%'.$contain.'%';
        $sql = "
            SELECT *
            FROM category
            WHERE name LIKE :contain;
        ";
        $params = [
            "contain"=>$contain
        ];

        return $this->getMultipleResults(
            DAO::select($sql,$params),
            $this->className
        );
    }

    public function nbPosts(int $id) :int{
        $sql = "
            SELECT COUNT(id_post) AS nbPosts
            FROM topic
            JOIN post
            ON post.topic_id = topic.id_topic
            WHERE category_id = :id;
        ";
        $params = [
            "id"=>$id
        ];
        $select=DAO::select($sql,$params,false);
        if ($select==null) {
            return 0;
        }
        return $select['nbPosts'];
    }

    public function nbTopics(int $id):int {
        $sql = "
            SELECT COUNT(id_topic) AS nbTopics
            FROM topic
            WHERE category_id = :id;
        ";
        $params = [
            "id"=>$id,
        ];
        $select=DAO::select($sql,$params,false);
        return $select['nbTopics'];
    }

    public function lastTopic($id):Topic {
        $sql = "
            SELECT topic.id_topic
            FROM topic
            JOIN post ON post.topic_id = topic.id_topic
            WHERE category_id = :id AND post.creationDate = (
                SELECT MAX(post.creationDate)
                FROM post
                JOIN topic ON post.topic_id = topic.id_topic
                WHERE category_id = :id
            )
            LIMIT 1;
        ";
        $params = [
            "id"=>$id,
        ];
        $select=DAO::select($sql,$params,false);

        if (isset($select['id_topic'])) {
            $topicManager = new TopicManager();
            return $topicManager->findOneById($select['id_topic']);
        }else {
            return null;
        }
    }

    public function findCategoriesWithCount() {

        $sql = "SELECT 
                    c.id_category,
                    c.name,
                    COUNT(DISTINCT t.id_topic) AS nbTopics,
                    COUNT(p.id_post) AS nbPosts
                FROM 
                    category c
                LEFT JOIN 
                    topic t ON c.id_category = t.category_id
                LEFT JOIN 
                    post p ON t.id_topic = p.topic_id
                GROUP BY 
                    c.id_category";
    

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

}