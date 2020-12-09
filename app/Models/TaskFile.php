<?php

namespace App\Models;

use Carbon\Traits\Date;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\TaskFile
 *
 * @property integer $task_id
 *
 * @property string $name
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer|null $deleted_by
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class TaskFile extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'task_files';

    /**
     * @var array
     */
    protected $fillable = [
        'task_id',

        'name',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'task_id' => 'integer',

        'name' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    /**
     * @param Builder $query
     *
     * @param string $key
     *
     * @param string|null $value
     *
     * @return Builder
     */
    public function scopeFindBy(Builder $query, string $key, string $value = null): Builder
    {
        return $query->where($key, '=', $value);
    }

    /**
     * @param Builder $query
     *
     * @param array $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function (Builder $query, string $search) {
            return $query->where(function (Builder $query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['title'] ?? null, function (Builder $query, $title){
            return $query->where('title', 'like', '%' . $title . '%');
        })->when($filters['note'] ?? null, function (Builder $query, $note){
            return $query->where('note', 'like', '%' . $note . '%');
        })->when($filters['creator_id'] ?? null, function (Builder $query, $creator_id){
            return $query->where('creator_id', '=', $creator_id);
        })->when($filters['project_id'] ?? null, function (Builder $query, $project_id){
            return $query->where('project_id', '=', $project_id);
        })->when($filters['in_may_day'] ?? null, function (Builder $query, $in_may_day){
            return $query->where('in_may_day', '=', $in_may_day);
        })->when($filters['is_completed'] ?? null, function (Builder $query, $is_completed){
            return $query->where('is_completed', '=', $is_completed);
        })->when($filters['is_important'] ?? null, function (Builder $query, $is_important){
            return $query->where('is_important', '=', $is_important);
        })->when($filters['remind_me_at'] ?? null, function (Builder $query, array $remind_me_at) {
            return $query->whereBetween('remind_me_at', $remind_me_at);
        })->when($filters['due_date'] ?? null, function (Builder $query, array $due_date) {
            return $query->whereBetween('due_date', $due_date);
        })->when($filters['next_repeat'] ?? null, function (Builder $query, array $next_repeat) {
            return $query->whereBetween('due_date', $next_repeat);
        });
    }
}
