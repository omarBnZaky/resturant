<?php

namespace App\Backend;

use App\Backend\Helper\Constant;
use App\Backend\Helper\Functions;
use App\Backend\Repositories\UserRepository;
use App\Role;
use App\RolesUsers;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
class User
{
    private $userRepo;
    private $userModel;
    public function __construct(
        UserRepository $userRepo,
        \App\User $userModel
    )
    {
        $this->userModel = $userModel;
        $this->userRepo = $userRepo;
    }
    /**
     * @param null $user_id
     * @return UserRepository|Model|object|null
     * @throws Exception
     */
    public function find($user_id = null)
    {
        $user = $this->userRepo
            ->getUserById(request('id') ?? $user_id)
            ->getUserByHashId(request('hash_id') ?? $user_id)
            ->getUserByEmail(request('email') ?? $user_id)
            ->firstUser();
        if (empty($user)) {
            throw new Exception();
        }
        return $user;
    }
    public function allUsers()
    {
        return $this->userRepo->getUser();
    }
    public function createUser()
    {
        $image = request()->get('profile');
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        Image::make(request()->get('profile'))->save(public_path('img/user/').$name);
        $user = $this->userModel->create([
            'hash_id' => Functions::generateUniqueHashForModel(new \App\User()),
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'status' => request('status'),
            'profile'=>$name,
            'org_id'=> request('org_id')
        ]);
        foreach(request('roles') as $role)
        {
            $user->roles()->attach($role['id']);
        }
        return $user;
    }
    public function updateUser(\App\User $user)
    {
        try {
            $idS= [];
            $user->update([
                'name' => request('name'),
                'email' => request('email'),
                'status' => request('status'),
                'org_id'=> request('org_id')
            ]);
     //Update password
            if(request('password')){
                $user->update(['password'=>Hash::make(request('password'))]);
            }
    //Update roles
            if(request('roles'))
            {
                foreach(request('roles') as $role)
                {   //if request role not in user's roles
                    $idS[] =$role['id'];
                }
                $user->roles()->sync($idS);
            }
            // Update profile image
            if(request()->input('profile'))
            {
                if(!$user->profile== "profile.png") {
                    $oldPicPath =public_path('img/user/').$user->profile;
                    if(file_exists($oldPicPath)){
                        unlink($oldPicPath);
                    }
                }
                $image = request()->get('profile');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                Image::make(request()->get('profile'))->save(public_path('img/user/').$name);
                $user->update(['profile'=>$name]);
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        return $user;
    }
    public function latestUsers(int $pagination)
    {
        return $this->userRepo->latestUsers()->with('roles')->paginate($pagination);
    }
    public function paginateUsers(int $pagination)
    {
        return $this->userRepo->paginateUsers($pagination);
    }
//
//    public function allPending()
//    {
//        return $this->userRepo->getPendingUsers()->count();
//    }
//
//    public function allBlocked()
//    {
//        return $this->userRepo->getBlockedUsers()->count();
//    }
//
//    public function allVerified()
//    {
//        return$this->userRepo->getVerifiedUsers()->count();
//    }
    public function verify(\App\User $user)
    {
        $user->update([
            'status' => Constant::VERIFIED
        ]);
    }
    public function block(\App\User $user)
    {
        $user->update([
            'status' => Constant::BLOCKED
        ]);
    }
    public function delete(\App\User $user)
    {
        try {
            $oldPicPath =public_path('img/user/').$user->profile;
            if(file_exists($oldPicPath)){
                unlink($oldPicPath);
            }
            $user->delete();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
