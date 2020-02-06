<?php

namespace App\Backend;

use App\Backend\Repositories\CategoryRepository;

class Category
{
  private $categoryRepo;

  public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

  public function allCategories()
    {
        return $this->categoryRepo->WithRelation('restaurant')->get();
    }

}