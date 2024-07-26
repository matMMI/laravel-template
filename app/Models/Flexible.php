<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Flexible extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'title',
        'last_check_date',
        'date_verification',
        'status',
        'etat',
        'controlleur',

    ];
    public function photos()
    {return $this->hasMany(Photo::class);}
}