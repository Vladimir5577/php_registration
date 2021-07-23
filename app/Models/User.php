<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static where(string $string, $email)
 */
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

    /**
     * @var bool
     */
   public $timestamps = false;

 }