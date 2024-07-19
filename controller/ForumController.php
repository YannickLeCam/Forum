<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use DateTime;
use Model\Entities\Post;
use Model\Entities\Topic;
use Model\Entities\User;
use Model\Managers\CategoryManager;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;

class ForumController extends AbstractController implements ControllerInterface{
    
    /**
     * verifyConnectedUser is a function to verify is user is connected if not he's redirect to connexion route else return user
     *
     * @return User 
     */
    private function verifyConnectedUser():User{
        $user = SESSION::getUser();
        if (!$user) {
            SESSION::addFlash('error','Vous devez etre connecté pour acceder a cette page . . .');
            header('Location:./index.php?ctrl=security&action=login');
            die;
        }else {
            return $user;
        }
    }

    public function index() {
        $this->verifyConnectedUser();
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
    //$id is category id
    public function listTopicsByCategory($id) {
        $user = $this->verifyConnectedUser();
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        if (isset($_POST['submitDeleteTopic'])) {
            $idTopic = filter_input(INPUT_GET,'idTopic',FILTER_VALIDATE_INT);
            if ($idTopic) {
                $topic=$topicManager->findOneById($idTopic);
                if ($topic->getUser()==$user->getId()||SESSION::isAdmin()) {
                    $topicManager->delete($topic->getId());
                }else {
                    SESSION::addFlash('error', "Vous n'avez pas la permission de supprimer ce topic . . .");
                }
            }else {
                SESSION::addFlash('error',"Le topic n'existe pas ou plus . . .");
            }
        }
        if (isset($_POST['deleteTopic'])) {
            $idTopic = filter_input(INPUT_GET,'idTopic',FILTER_VALIDATE_INT);
            if ($idTopic) {
                $topic=$topicManager->findOneById($idTopic);
                if ($topic->getUser()->getId()==$user->getId()||SESSION::isAdmin()) {
                    $topicManager->delete($topic->getId());
                    header('Location:./index.php?ctrl=forum&action=listTopicsByCategory&id='.$id);
                }else {
                    SESSION::addFlash('error', "Vous n'avez pas la permission de supprimer ce message . . .");
                }
            }else {
                SESSION::addFlash('error',"Le topic n'existe pas ou plus . . .");
            }
        }

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }
    //$id is topic id
    public function listPostsByTopic($id) {
        $user=$this->verifyConnectedUser();
        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        if (isset($_POST['submitNewPost'])) {
            # data traitements if error all data in $data
            $postManager = new PostManager();
            $data["message"]=filter_input(INPUT_POST,'message',FILTER_SANITIZE_SPECIAL_CHARS);
            $data['user_id'] = $user->getId(); // En attendant que le login se fasse
            $data['topic_id']=$topic->getId();
            $date = new DateTime();
            $data['creationDate']=$date->format('Y-m-d H:i:s');
            if ($data) {
                $idNewPost=$postManager->insertData($data);
            }
            //Pour reset la page afin que le message s'affiche directement
            header('Location:./index.php?ctrl=forum&action=listPostsByTopic&id='.$topic->getId());
        }

        if (isset($_POST['submitEdit'])) {
            $message = filter_input(INPUT_POST,'message',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idPost = filter_input(INPUT_GET,'idPost',FILTER_VALIDATE_INT);
            if ($idPost && ($message || $message!="")) {
                $post = $postManager->findOneById($idPost);
                if ($user->getId()==$post->getUser()->getId()) {
                    $data=[
                        'id'=>$idPost,
                        'message' => $message
                    ];
                    if ($postManager->updateMessage($data)) {
                        header('Location:./index.php?ctrl=forum&action=listPostsByTopic&id='.$topic->getId());
                    }
                }
            }
        }

        if (isset($_POST['deletePost'])) {
            var_dump($_GET);
            $idPost = filter_input(INPUT_GET,'idPost',FILTER_VALIDATE_INT);
            if ($idPost) {
                $post=$postManager->findOneById($idPost);
                if ($post->getUser()->getId()==$user->getId()||SESSION::isAdmin()) {
                    $postManager->delete($post->getId());
                    header('Location:./index.php?ctrl=forum&action=listPostsByTopic&id='.$topic->getId());
                }else {
                    SESSION::addFlash('error', "Vous n'avez pas la permission de supprimer ce message . . .");
                }
            }else {
                SESSION::addFlash('error',"Le post n'existe pas ou plus . . .");
            }
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
    //$id is category id 
    public function newTopic ($id){

        $user = $this->verifyConnectedUser();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        if (isset($_POST['submitNewTopic'])) {
            $message=filter_input(INPUT_POST,'message',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['title']=filter_input(INPUT_POST,'title',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($message && $data['title']) {
                $topicManager = new TopicManager();
                $postManager = new PostManager();
                $user=SESSION::getUser();
                $data['user_id']=$user->getId();
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
                    $idNewPost=$postManager->insertData($data);
                    if ($idNewPost) {
                        //if post is right
                        header('Location:./index.php?ctrl=forum&action=listPostsByTopic&id='.$data['topic_id']);
                    }
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
}