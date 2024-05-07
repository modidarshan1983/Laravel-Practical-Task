<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Healthcare extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'specialty']; // Define fillable attributes

    // Example of defining a relationship (e.g., appointments)
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
}
