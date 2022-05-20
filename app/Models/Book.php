<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Book extends Model
{
    use HasFactory, HasApiTokens;
    public $timestamps = false;
    protected $fillable = ['auther_id', 'title', 'description', 'book_cost'];
}
