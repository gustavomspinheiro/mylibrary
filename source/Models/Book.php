<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Source\Models;

use Source\Core\Model;
use Source\Models\Category;

/**
 * Description of Book
 *
 * @author Gustavo Pinheiro
 */
class Book extends Model {

    public function __construct() {
        parent::__construct("books", ["id"], ["category", "title", "summary", "author", "pages_count", "publish_date", "inventory"]);
    }

    /**
     * Responsible for searching a certain book by title or summary
     * @param string $search
     * @return array|null
     */
    public function bookSearch(string $search): ?array {
        $searchRefined = filter_var($search, FILTER_SANITIZE_STRIPPED);
        $books = $this->find("MATCH(title, summary) AGAINST(:s)", "s={$searchRefined}")->fetch(true);

        if ($books) {
            return $books;
        }

        return null;
    }

    /**
     * Get Book Category
     * @return Category|null
     */
    public function category(): ?Category {
        $category = new Category();
        return $category->categoryById($this->category);
    }

}
