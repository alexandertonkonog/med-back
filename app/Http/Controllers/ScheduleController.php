<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Services\ScheduleService;
use App\Http\Controllers\Controller;
use App\Http\Filters\ScheduleFilter;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Schedule\FindRequest;
use App\Http\Requests\Schedule\CreateRequest;
use App\Http\Requests\Schedule\FilterRequest;
use App\Http\Requests\Schedule\UpdateRequest;

class ScheduleController extends Controller
{
    function __construct() {
        $this->service = new ScheduleService([
            'attributes' => [
                'manyToMany' => []
            ],
            'model' => Schedule::class,
            'rightName' => 'appointment',
            'filter' => ScheduleFilter::class,
            'checkSelect' => true,
            'replaceValues' => ['owner' => 'scheduleable']
        ]);
    }

    public function select(FilterRequest $request) {
        return $this->service->select($request);
    }

    public function find(FindRequest $request, int $id) {
        return $this->service->find($request, $id);
    }

    public function create(CreateRequest $request) {
        return $this->service->create($request);
    }

    public function update(UpdateRequest $request) {
        return $this->service->update($request);
    }
    
    public function delete(DeleteRequest $request) {
        return $this->service->delete($request);
    }   
}
