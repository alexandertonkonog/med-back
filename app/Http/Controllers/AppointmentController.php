<?php

namespace App\Http\Controllers;

use App\Services\AppointmentService;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Filters\AppointmentFilter;
use App\Http\Requests\Appointment\CreateRequest;
use App\Http\Requests\Appointment\FilterRequest;
use App\Http\Requests\Appointment\UpdateRequest;

class AppointmentController extends Controller
{
    function __construct() {
        $this->service = new AppointmentService([
            'attributes' => [
                'manyToMany' => []
            ],
            'model' => Appointment::class,
            'rightName' => 'appointment',
            'filter' => AppointmentFilter::class,
            'checkSelect' => true
        ]);
    }

    public function index(FilterRequest $request) {
        return $this->service->select($request);
    }

    public function store(CreateRequest $request) {
        return $this->service->create($request);
    }

    public function update(UpdateRequest $request) {
        return $this->service->update($request);
    }
    
    public function destroy(DeleteRequest $request) {
        return $this->service->delete($request);
    }   
}
