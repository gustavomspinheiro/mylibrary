<?php

namespace Source\Models;
use Source\Core\Model;

/**
 * Description of Category
 *
 * @author Gustavo Pinheiro
 */
class Category extends Model {
    
    public function __construct() {
        parent::__construct("categories", ["id"], ["category"]);
    }
    
    public function categoryById(int $id){
        return parent::findById($id);
    }
}
