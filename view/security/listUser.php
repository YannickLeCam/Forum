<?php
$user= $result['data']['user'];
$listUser = $result['data']['listUser'];

var_dump($user);
var_dump($listUser);

?>


<h1>Liste des Users</h1>

<div id="cardsList">
    <?php
        foreach ($listUser as $key => $userListed) {
            if ($userListed->getId()!=$user->getId()) {
                $color = ($userListed->getRole() == 'ADMIN' ? 'danger' : 'primary');
                var_dump($userListed->getRole());
                echo <<<HTML
                <div class="card border-$color mb-3" style="max-width: 18rem;">
                    <div class="card-header">$userListed</div>
                    <div class="card-body text-$color">
                        <h5 class="card-title">{$userListed->getEmail()}</h5>
                    </div>
                    <a href="./index.php?ctrl=security&action=userDetail&id={userListed->getId()}"class="btn btn-$color"> Voir plus </a>
                </div>
HTML;
            }
        }
    ?>
</div>