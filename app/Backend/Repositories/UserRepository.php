<?php
namespace App\Backend\Repositories;
use App\Backend\Helper\Constant;
use App\User;
use Illuminate\Support\Facades\Auth;
class UserRepository
{
    private $userModel;
    /**
     * UserRepository constructor.
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel->newQuery();
    }
    public function newQuery()
    {
        $this->userModel = $this->userModel->newModelInstance();
        return $this;
    }
    public function getUserById($id)
    {
        $this->userModel = $this->userModel->where('id', $id);
        return $this;
    }
    public function getUserByHashId($hash_id)
    {
        $this->userModel = $this->userModel->orWhere('hash_id', $hash_id);
        return $this;
    }
    public function getUserByEmail($email)
    {
        $this->userModel = $this->userModel->orWhere('email', $email);
        return $this;
    }
    public function countUsers()
    {
        $this->userModel = $this->userModel->count();
        return $this;
    }
    public function firstUser()
    {
        return $this->userModel->first();
    }
    public function getVerifiedUsers(){
        $this->userModel = $this->userModel->where('status', '=', Constant::VERIFIED)->with('roles');
        return $this;
    }
    public function getBlockedUsers(){
        $this->userModel = $this->userModel->where('status', '=', Constant::BLOCKED)->with('roles');
        return $this;
    }
    public function getPendingUsers()
    {
        $this->userModel = $this->userModel->where('status', '=', Constant::PENDING)->with('roles');
        return $this;
    }
    public function getUser()
    {
        return $this->userModel->with('roles')->get();
    }
    public function latestUsers()
    {
        return $this->userModel->with('roles')->latest();
    }
    public function paginateUsers($pagination){
        return $this->userModel->with('roles')->with('org')->paginate($pagination);
    }
    public function paginateOrgUsers($pagination)
    {
        return $this->userModel
            ->where('org_id', Auth::guard('organization')->user()->id)
            ->with('roles')
            ->paginate($pagination);
    }
}
