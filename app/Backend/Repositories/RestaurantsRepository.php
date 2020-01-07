<?php
namespace App\Backend\Repositories;
use App\Backend\Helper\Constant;
use App\Restaurant;
use Illuminate\Support\Facades\Auth;
class RestaurantsRepository
{
    private $resturantModel;
    /**
     * UserRepository constructor.
     */
    public function __construct(Restaurant $resturantModel)
    {
        $this->resturantModel = $resturantModel->newQuery();
    }
    public function newQuery()
    {
        $this->resturantModel = $this->resturantModel->newModelInstance();
        return $this;
    }
    public function getRestoById($id)
    {
        $this->resturantModel = $this->resturantModel->where('id', $id);
        return $this;
    }
 
    public function countRestos()
    {
        $this->resturantModel = $this->resturantModel->count();
        return $this;
    }

    public function countUserRestos($user)
    {
        $this->resturantModel = $this->resturantModel
                    ->where('user_id', $user)
					->count();
        return $this;
    }

    public function firstResto()
    {
        return $this->resturantModel->first();
    }

    public function getResto()
    {
        return $this->resturantModel->get();
    }
    public function latestResto()
    {
        return $this->resturantModel->latest();
    }
    public function paginateRestos($pagination){
        return $this->resturantModel->paginate($pagination);
    }
    public function paginateUserRestos($pagination,$user)
    {
        return $this->resturantModel
            ->where('user_id', $user)
            ->paginate($pagination);
    }
}
