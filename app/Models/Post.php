<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 *     title="Post model",
 *     description="포스팅 모델 입니다.",
 *     @OA\Xml(
 *         name="Post"
 *     )
 * )
 */

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'is_published',
    ];
}
