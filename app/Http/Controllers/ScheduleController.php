<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Filters\ScheduleFilter;
use App\Http\Requests\Schedule\CreateRequest;
use App\Http\Requests\Schedule\FilterRequest;
use App\Http\Requests\Schedule\UpdateRequest;
use App\Models\Schedule;

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
            'checkSelect' => true
        ]);
    }

    public function select(FilterRequest $request) {
        return $this->service->select($request);
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
