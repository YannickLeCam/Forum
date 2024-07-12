<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
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
                    $session->addFlash("error","Le mot de passe doit contenir : Une lettre minuscule , Une lettre Majuscule, un charactere spécial et un chiffre minimum . . .");                    
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
            $session = new Session();

            $data['email']=filter_input(INPUT_POST,'email',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_VALIDATE_EMAIL);
            $data['password']=filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $userManager = new UserManager();
            $user = $userManager->getUserByEmail($data['email']);

            $data['password']= password_hash($data['password'],PASSWORD_DEFAULT);
            
            if ($user) {
                
                if ($user->getPassword() == $data['password']) {
                    $session->setUser($user);
                    $session->addFlash("success","Vous etes bien connecté !");
                }
                else {
                    $session->addFlash('error','Email ou mot de passe semble etre incorrect');
                }
                var_dump($user);die;
            }else {
                $session->addFlash('error','Email ou mot de passe semble etre incorrect');
            }
            
        }
        return [
            "view" => VIEW_DIR."security/login.php",
            "meta_description" => "Connexion"
        ];
    }
    public function logout () {
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "home"
        ];
    }
}