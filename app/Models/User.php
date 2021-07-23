<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
       'email',
       'password', 
       'key', 
       'name', 
       'photo',
   ];

   public $timestamps = false;

 }