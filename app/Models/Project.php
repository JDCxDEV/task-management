<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Define a many-to-many relationship between projects and tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
