<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
 
{
 
   // protected $table = 'schools';
 
   protected $fillable = ['user_id','route','qty','unit_price','amount','total','username'];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
        // return $this->belongsTo('App\User');
    }
 
}
