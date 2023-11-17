<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array[] $data)
 */
class Operation extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = "operations";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'name'
    ];
}
