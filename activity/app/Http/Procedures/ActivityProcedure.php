<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\Activity\CreateRequest;
use App\Http\Requests\Activity\ShowRequest;
use Sajya\Server\Procedure;
use App\Repositories\ActivityRepository;

class ActivityProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'activity';

    private ActivityRepository $repository;

    public function __construct(ActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateRequest $request)
    {
        $url = $request->get('url');
        $visit_date = $request->get('visit_date');

        return $this->repository->create([
            'activity_url' => $url,
            'activity_visit_date' => $visit_date
        ]);
    }

    public function show(ShowRequest $request)
    {
        return $this->repository->show($request->get('page'));
    }
}
