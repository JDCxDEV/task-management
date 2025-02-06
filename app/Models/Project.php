<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DateTrait;

class Project extends Model
{
    use HasFactory, SoftDeletes, DateTrait;

    protected $dates = ['deleted_at'];

    /**
     * Define a many-to-many relationship between projects and tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /*
	|--------------------------------------------------------------------------
	| @Renders
	|--------------------------------------------------------------------------
	*/
    public function renderArchiveUrl() {
        return route('project.archive', $this->id);
    }

    public function renderRestoreUrl() {
        return route('project.restore', $this->id);
    }
}
