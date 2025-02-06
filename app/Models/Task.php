<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DateTrait;

class Task extends Model
{
    use HasFactory, SoftDeletes, DateTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'priority',
        'project_id'
    ];

    /**
     * Define the relationship to the project that owns this task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /*
	|--------------------------------------------------------------------------
	| @Renders
	|--------------------------------------------------------------------------
	*/
    public function renderViewUrl() {
        return route('task.view', $this->id);
    }
    public function renderUpdateUrl() {
        return route('task.update', $this->id);
    }

    public function renderArchiveUrl() {
        return route('task.archive', $this->id);
    }

    public function renderRestoreUrl() {
        return route('task.restore', $this->id);
    }
}
