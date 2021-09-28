<?php
namespace App\Repositories;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ActivityRepository
{
    private Activity $model;

    public function __construct(Activity $activity)
    {
        $this->model = $activity;
    }

    public function create(array $attrs): bool
    {
        try {
            $this->model->query()->create($attrs);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function show($page): ?LengthAwarePaginator
    {
        return $this->model->query()
            ->select(DB::raw("url, count(*) as visits, max(activity_visit_date) as last_visit"))
            ->groupBy('activity_url')
            ->paginate(20, null, null, $page);
    }
}