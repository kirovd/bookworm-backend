<?php

/**
 * @OA\Schema(
 *     schema="Favorite",
 *     type="object",
 *     title="Favorite",
 *     description="Favorite model",
 *     properties={
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             description="Favorite ID"
 *         ),
 *         @OA\Property(
 *             property="book_id",
 *             type="string",
 *             description="Book ID"
 *         ),
 *         @OA\Property(
 *             property="created_at",
 *             type="string",
 *             format="date-time",
 *             description="Timestamp when favorite was created"
 *         ),
 *         @OA\Property(
 *             property="updated_at",
 *             type="string",
 *             format="date-time",
 *             description="Timestamp when favorite was updated"
 *         )
 *     }
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id', 'title', 'author', 'price', 'rating'
    ];
}


