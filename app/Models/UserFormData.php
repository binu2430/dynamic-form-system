<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFormData extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'form_id', 'data','field_snapshot'];

    protected $casts = [
        'data' => 'array',
        'field_snapshot' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}