<?php 

namespace App\Backend\Helpers;

use Illuminate\Database\Eloquent\Model;
class Functions
{
    /**
     * @param int $length
     * @return bool|string
     */
    public static function generateRandomHash(int $length = 20)
    {
        $hash = hash("sha256", microtime() . " " . uniqid());
        if ($length > 64)
            return $hash;
        return substr($hash, 0, $length);
    }
    /**
     * @param Model $model
     * @param int $length
     * @return bool|string
     */
    public static function generateUniqueHashForModel(Model $model, int $length = 20)
    {
        $model = $model->newQuery();
        do {
            $hash = self::generateRandomHash($length);
        } while ($model->where('hash_id', $hash)->first() != null);
        return $hash;
    }
    /**
     * @param $model
     * @param $delete
     * @return string
     */
    public static function deleteModal($model, $delete)
    {
        return ' 
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete'.$model->id.'">Delete</button>
            
            <div class="modal fade show" id="delete'.$model->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 15px;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="'.route($delete.'.delete', $model->id).'" method="post">
                            <input type="hidden" name="_token" id="csrf-token" value="'.\Session::token().'" />
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are You Sure You Want To Delete This ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                &nbsp;&nbsp;
                                <button type="submit" class="btn btn-danger">Sure</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>' ;
    }
}