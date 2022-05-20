<?php

namespace App\Models;

use App\Models\Book;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;

class Author extends Model implements AuthenticateContract
{
    use HasFactory, HasApiTokens, Authenticatable;

    public $timestamps = false;

    protected $fillable = ['name', 'email', 'phone_no', 'password'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
