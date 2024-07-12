<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use DateTime;
use Model\Entities\Post;
use Model\Entities\Topic;
use Model\Managers\CategoryManager;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    public function listPostsByTopic($id) {

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $posts = $postManager->findTopicsByCategory($id);

        if (isset($_POST['submitNewPost'])) {
            # data traitements if error all data in $data
            $postManager = new PostManager();
            $data["message"]=filter_input(INPUT_POST,'message',FILTER_SANITIZE_SPECIAL_CHARS);
            $data['user_id'] = 1; // En attendant que le login se fasse
            $data['topic_id']=$topic->getId();
            $date = new DateTime();
            $data['creationDate']=$date->format('Y-m-d H:i:s');
            if ($data) {
                $idNewPost=$postManager->insertData($data);
            }
            //Pour reset la page afin que le message s'affiche directement
            header('Location:./index.php?ctrl=forum&action=listPostsByTopic&id='.$topic->getId());
        }
        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts par topic : ".$topic,
            "data" => [
                "topic" => $topic,
                "posts" => $posts
            ]
        ];
    }

    public function newTopic ($id){
        
        
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        if (isset($_POST['submitNewTopic'])) {
            $message=filter_input(INPUT_POST,'message',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['title']=filter_input(INPUT_POST,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($message && $data['title']) {
                $topicManager = new TopicManager();
                $postManager = new PostManager();

                $data['user_id']=1;
                $date= new DateTime();
                $data['creationDate'] = $date->format('Y-m-d H:i:s');
                $data['category_id']=$id;
                $data['closed']=0;
                
                $data['topic_id']=$topicManager->insertTopic($data);

                
                if ($data['topic_id']) {
                    //faut faire le traitement de la data
                    $data['message']=$message;
                    unset($data['title']);
                    unset($data['category_id']);
                    unset($data['closed']);
                    $postManager->insertData($data);
                }

            }

        }
        return [
            "view" => VIEW_DIR."forum/newTopic.php",
            "meta_description"=>"Edition d'un nouveau post dans la catégorie:" .$category,
            "data" => [
                "category" => $category
            ]
        ];
    }

    // $id is topic id
    public function newPost($id){
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $data=[];

        // var_dump($test);
        if (isset($_POST['submitNewPost'])) {
            # data traitements if error all data in $data
            $postManager = new PostManager();
            $data["message"]=filter_input(INPUT_POST,'message',FILTER_SANITIZE_SPECIAL_CHARS);
            $data['user_id'] = 1; // En attendant que le login se fasse
            $data['topic_id']=$topic->getId();
            $date = new DateTime();
            $data['creationDate']=$date->format('Y-m-d H:i:s');
            if ($data) {
                $postManager->insertData($data);
            }
        }
        
        return [
            "view" => VIEW_DIR."forum/newPost.php",
            "meta_description"=>"Edition d'un nouveau post sur le topic : " .$topic,
            "data" => [
                "topic"=>$topic,
                "data"=>$data
            ]
        ];
    }
    
}