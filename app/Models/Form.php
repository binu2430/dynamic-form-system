<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [    'user_id', 'name', 'country_code', 'is_active'];



        public function user()
        {
            return $this->belongsTo(User::class);
        }

        // Update the fields relationship to ensure proper ordering
        public function fields()
        {
            return $this->hasMany(FormField::class)->orderBy('order');
        }

    public function submissions()
    {
        return $this->hasMany(UserFormData::class);
    }
}