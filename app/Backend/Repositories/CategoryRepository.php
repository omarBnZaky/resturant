<?php
namespace App\Backend\Repositories;
use App\Backend\Helper\Constant;
use App\Category;
use Illuminate\Support\Facades\Auth;
class CategoryRepository
{
    private $categoryModel;
    /**
     * UserRepository constructor.
     */
    public function __construct(User $categoryModel)
    {
        $this->categoryModel = $categoryModel->newQuery();
    }
    public function newQuery()
    {
        $this->categoryModel = $this->categoryModel->newModelInstance();
        return $this;
    }
    public function getCatById($id)
    {
        $this->categoryModel = $this->categoryModel->where('id', $id);
        return $this;
    }
 
    public function countCategories()
    {
        $this->categoryModel = $this->categoryModel->count();
        return $this;
    }

    public function countRestaurantCategories($resturant)
    {
        $this->categoryModel = $this->categoryModel
                    ->where('resturant_id', $resturant)
					->count();
        return $this;
    }

    public function firstCat()
    {
        return $this->categoryModel->first();
    }

    public function getCategory()
    {
        return $this->categoryModel->get();
    }
    public function latestCategory()
    {
        return $this->categoryModel->latest();
    }
    public function paginateCategories($pagination){
        return $this->categoryModel->paginate($pagination);
    }
    public function paginateRestoCategories($pagination,$resturant)
    {
        return $this->categoryModel
            ->where('resturant_id', $resturant)
            ->paginate($pagination);
    }
}
