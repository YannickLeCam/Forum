<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

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
}