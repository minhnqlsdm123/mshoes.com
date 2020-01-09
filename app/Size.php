<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['size'];

    protected $table = 'sizes';
    
    public static function storeData($data)
    {
        $sizes = [];
        foreach ($data as $key => $value) {

            if(str_contains($key, 'size')){
                $size_exist = Size::where('size','=',$value)->first();
                if (!$size_exist) {
                    $new_size = Size::create(['size'=>$value]);
                    $sizes[] = $new_size['id'];
                    
                } else {
                    $sizes[] = $size_exist['id'];
                }
            }
        }
        // dd($sizes);
        return $sizes;
    }
    
}
