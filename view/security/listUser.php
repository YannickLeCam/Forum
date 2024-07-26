<?php
$user= $result['data']['user'];
$listUser = $result['data']['listUser'];
?>


<h1>Liste des Users</h1>

<div id="cardsList">
    <?php
        foreach ($listUser as $key => $userListed) {
            if ($userListed->getId()!=$user->getId()) {
                $color = ($userListed->getRole() == 'ADMIN' ? 'danger' : 'primary');
                $userListed->getBanned() ? $banned = "A été bannit jusqu'au ".$userListed->getBanned(): $banned="Le joueur n'a jamais été bannie";
                echo <<<HTML
                <div class="card border-$color mb-3 cardUserList" style="max-width: 18rem;">
                    <div class="card-header">$userListed</div>
                    <div class="card-body">
                        <h5 class="card-title">{$banned}</h5>
                    </div>
                    <a href="./index.php?ctrl=security&action=userDetail&id={$userListed->getId()}"class="btn"> Voir plus </a>
                </div>
HTML;
            }
        }
    ?>
</div>