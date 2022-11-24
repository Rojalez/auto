<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Order extends Model
{
    use HasFactory;
  
    public function parts()
    {
        return $this->hasMany('App\Models\Part');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:m:s',
    ];

}