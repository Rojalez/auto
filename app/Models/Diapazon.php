<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Diapazon extends Model
{
    use HasFactory;

    protected $table = 'diapazon';
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_price', 'to_price', 'procent'
    ];
}