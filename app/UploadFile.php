<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class UploadFile extends Model
 
{
 
   // protected $table = 'schools';
 
   protected $fillable = ['username','picture', 'video'];

    // public function users(){
    //     return $this->belongTo(User::class, 'user_id');
    // }
 
}
