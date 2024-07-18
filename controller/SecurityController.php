<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    private function isStrongPassword($password) {
        // Expression régulière pour vérifier la force du mot de passe
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{12,}$/';
        
        // Vérifie si la chaîne correspond à l'expression régulière
        if (preg_match($regex, $password)) {
            return true; // Le mot de passe est fort
        } else {
            return false; // Le mot de passe est faible
        }
    }

    public function register () {
        if (isset($_POST['submitRegister'])) {
            $userManager = new UserManager();
            $session = new Session();

            $data['nickName']=filter_input(INPUT_POST,'nickName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['email']=filter_input(INPUT_POST,'email',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_VALIDATE_EMAIL);
            $data['password']=filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data['passwordConfirm']=filter_input(INPUT_POST,'passwordConfirm',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($data['nickName']&$data['email']&$data['password']&$data['passwordConfirm']) {
                $error=false;

                if (!($data['password'] === $data['passwordConfirm'])) {
                    $session->addFlash("error","Les mots de passe ne semble ne pas être identique . . .");                    
                    $error=true;
                }
                if (strlen($data['password']) < 12) {
                    $session->addFlash("error","Le mot de passe doit contenir : Il faut un minimum de 12 chars");                    
                    $error=true;
                }
    
                if (!$this->isStrongPassword($data['password'])) {
                    $session->addFlash("error","Le mot de passe doit contenir : Une lettre minuscule , Une lettre Majuscule, un charactere spécial et un chiffre minimum . . .");
                    $error=true;
                }
                
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
        
                if ($data['nickName'] == "" && $data['nickName'] < 5) {
                    $session->addFlash("error","Il semble manquer des éléments . . .");
                    $error=true;
                }

                if ($userManager->getUserByEmail($data['email'])) {
                    $session->addFlash("error","L'adresse mail semble déja être utilisée . . .");
                    $error=true;
                }

                unset($data['passwordConfirm']);

                if (!$error) {
                    $idNewUser= $userManager->insertUser($data);
                    if ($idNewUser) {
                        $session->addFlash("success","Votre compte a bien été enregistré !");
                    }else {
                        $session->addFlash("error","Il semble y avoir un probleme dans la BDD");
                    }
                }

            }else {
                $session->addFlash("error","Il semble manquer des éléments . . .");

            }

        }
        return [
            "view" => VIEW_DIR."security/register.php",
            "meta_description" => "Inscription"
        ];
    }
    public function login () {
        if (isset($_POST['submitLogin'])) {
            var_dump(SESSION::getCsrfToken());
            var_dump($_POST);die;
            $session = new Session();
            if ((filter_var(SESSION::getCsrfToken(),FILTER_SANITIZE_FULL_SPECIAL_CHARS)!=filter_input(INPUT_POST,'csrf_',FILTER_SANITIZE_FULL_SPECIAL_CHARS))|| $_POST['jsuispasunhoneypot']!='') {
                $session->addFlash('error','Oulah stop ! il semble y avoir un problème !');
                header('Location:./index.php');
                die;
            }
            $data['email']=filter_input(INPUT_POST,'email',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_VALIDATE_EMAIL);
            $data['password']=filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $userManager = new UserManager();
            $user = $userManager->getUserByEmail($data['email']);
            var_dump($user->getPassword());
            var_dump(password_verify($data['password'],$user->getPassword() ));
            if ($user) {
                if ($user->getBanned()!=null) {
                    $session->addFlash('error', 'Vous etes bannit ! Vilain !');
                }
                else{
                    if (password_verify($data['password'],$user->getPassword() )) {
                        $session->setUser($user);;
                        $session->addFlash("success","Vous etes bien connecté !");
                    }
                    else {
                        $session->addFlash('error','Email ou mot de passe semble etre incorrect');
                    }
                }
            }
            else {
                $session->addFlash('error','Email ou mot de passe semble etre incorrect');
            }
            
        }
        return [
            "view" => VIEW_DIR."security/login.php",
            "meta_description" => "Connexion"
        ];
    }
    public function logout (){

        if (SESSION::getUser()) {
            unset($_SESSION['user']);
        }
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "home"
        ];
    }

    public function profile(){
        $user= SESSION::getUser();
        if (!$user) {
            return [
                "view" => VIEW_DIR."home.php",
                "meta_description" => "home"
            ];
        }
        if (isset($_POST['submitEditNickName'])) {

            $newNickName = filter_input(INPUT_POST,'nickName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($newNickName) {
                if ($newNickName<5) {
                    SESSION::addFlash('error','Le pseudo doit faira au minimum de 5 charactères');
                }else {
                    $userManager = new UserManager();
                    $veri = $userManager->editPseudo($newNickName , $user->getId());
                    if ($veri) {
                        SESSION::addFlash('success','Vous avez bien modifier votre pseudo');
                    }
                }
            }else {
                SESSION::addFlash('error','Il semblerait manquer un pseudo . . .');
            }
        }
        if (isset($_POST['submitEditPassword'])) {
            $password =  filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $passwordConfirm =  filter_input(INPUT_POST,'passwordConfirm',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($password && $passwordConfirm) {
                $lock = true;
                if ($password !== $passwordConfirm) {
                    SESSION::addFlash('error','Les mots de passe semble ne pas etre identiques . . .');
                    $lock = false;
                }
                if (!($this->isStrongPassword($password))) {
                    SESSION::addFlash("error","Le mot de passe doit contenir : Une lettre minuscule , Une lettre Majuscule, un charactere spécial et un chiffre minimum . . .");
                    $lock=false;
                }

                if ($lock) {
                    $userManager = new UserManager();
                    $veri = $userManager->editPassword($password,$user->getId());
                    if ($veri) {
                        SESSION::addFlash('success','Vous avez bien modifier votre mot de passe !');
                    }else {
                        SESSION::addFlash("error","L'insertion du mot de passe semble ne pas avoir fonctionné . . .");
                    }
                }
            }
        }

        return [
            "view"=> VIEW_DIR."security/profile.php",
            "meta_description" => "profile",
            "data" =>[
                "user" =>$user
            ]
        ];
    }

    public function listUser(){
        $user = SESSION::getUser();
        if (!SESSION::isAdmin()) {
            SESSION::addFlash('error','Vous n\'avez pas accès a cette page . . .');
            return [
                "view" => VIEW_DIR."home.php",
                "meta_description" => "home"
            ];
        }

        $userManager = new UserManager();
        $listUser = $userManager->findAll();

        return [
            "view" => VIEW_DIR."security/listUser.php",
            "meta_description" => "liste users",
            "data" => [
                "user" => $user,
                'listUser' => $listUser
            ]
        ];
    }

    public function userDetail(int $id){
        if (!SESSION::isAdmin()) {
            SESSION::addFlash('error','Vous n\'avez pas accès a cette page . . .');
            return [
                "view" => VIEW_DIR."home.php",
                "meta_description" => "home"
            ];
        }
        $userManager = new UserManager();
        $userSelected=$userManager->findOneById($id);
        $topicManager=new TopicManager();
        $userSelectedTopics = $topicManager->findTopicsByIdUser($id);
        $postManager = new PostManager();
        $userSelectedPosts = $postManager->findPostsByIdUser($id);

        if (isset($_POST['submitButtonAddAdmin'])) {
            $verify=$userManager->updateRoleToAdmin($id);
            if ($verify) {
                SESSION::addFlash('succes',"L'utilisateur $userSelected est devenu un Admin !");
                header('Location:./index.php?ctrl=security&action=userDetail&id='.$userSelected->getId());
                die;
            }else {
                SESSION::addFlash('error','Il semble y avoir un probleme sur la mise en place du nouvel Admin . . .');
                
            }
        }

        if (isset($_POST['submitButtonUnban'])) {
            $verify = $userManager -> unbanUser($id);
            if ($verify) {
                SESSION::addFlash('success',"Vous avez débannie $userSelected !");
                header('Location:./index.php?ctrl=security&action=userDetail&id='.$userSelected->getId());
                die;
            }else {
                SESSION::addFlash('error','Il semble y avoir un probleme sur la mise en place du nouvel Admin . . .');
            }
        }
        if (isset($_POST['submitButtonBan'])) {
            $verify = $userManager -> banUser($id);
            if ($verify) {
                SESSION::addFlash('success',"Vous avez bannie $userSelected !");
                header('Location:./index.php?ctrl=security&action=userDetail&id='.$userSelected->getId());
                die;
            }else {
                SESSION::addFlash('error','Il semble y avoir un probleme sur la mise en place du nouvel Admin . . .');
            }
        }

        return [
            "view" => VIEW_DIR."security/detailUser.php",
            "meta_description" => "detail utilisateur",
            "data" => [
                "userSelected" => $userSelected,
                "userSelectedTopics" => $userSelectedTopics,
                "userSelectedPosts" => $userSelectedPosts
            ]
        ];
    }

}