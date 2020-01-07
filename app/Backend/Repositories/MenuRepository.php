<?php
namespace App\Backend\Repositories;
use App\Backend\Helper\Constant;
use App\Menu;
use Illuminate\Support\Facades\Auth;
class MenuRepository
{
    private $MenuModel;
    /**
     * UserRepository constructor.
     */
    public function __construct(Menu $MenuModel)
    {
        $this->MenuModel = $MenuModel->newQuery();
    }
    public function newQuery()
    {
        $this->MenuModel = $this->MenuModel->newModelInstance();
        return $this;
    }
    public function getMenuById($id)
    {
        $this->MenuModel = $this->MenuModel->where('id', $id);
        return $this;
    }
 
    public function countMenus()
    {
        $this->MenuModel = $this->MenuModel->count();
        return $this;
    }

    public function countCategoryMenus($user)
    {
        $this->MenuModel = $this->MenuModel
                    ->where('category_id', $user)
					->count();
        return $this;
    }

    public function firstMenu()
    {
        return $this->resturantModel->first();
    }

    public function getMenu()
    {
        return $this->resturantModel->get();
    }
    public function latestMenu()
    {
        return $this->resturantModel->latest();
    }
    public function paginateMenus($pagination){
        return $this->resturantModel->paginate($pagination);
    }
    public function paginateUserRestos($pagination,$category)
    {
        return $this->resturantModel
            ->where('category_id', $category)
            ->paginate($pagination);
    }
}
