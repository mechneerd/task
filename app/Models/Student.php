<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Student extends Model
{
    use HasFactory;

    // Specify the primary key
    protected $primaryKey = 'student_id';

    public $incrementing = false;
    
    protected $fillable = [
        'student_id',
        'user_id',
        'name',
        'subject',
        'marks', 
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
