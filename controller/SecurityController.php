<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {
        if (isset($_POST['submitRegister'])) {
            filter_input(INPUT_POST,'nickName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            var_dump($_POST);die;
        }
        return [
            "view" => VIEW_DIR."security/register.php",
            "meta_description" => "Inscription"
        ];
    }
    public function login () {
        if (isset($_POST['submitLogin'])) {
            var_dump($_POST);die;
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