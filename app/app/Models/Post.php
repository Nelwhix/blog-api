<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Post extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'blogTitle',
        'coverPhotoName',
        'blogHTML',
        'coverPhotoURL'
    ];
}
