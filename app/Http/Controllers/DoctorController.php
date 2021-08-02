<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Services\MainService;
use App\Http\Filters\DoctorFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Doctor\CreateRequest;
use App\Http\Requests\Doctor\FilterRequest;
use App\Http\Requests\Doctor\UpdateRequest;

class DoctorController extends Controller
{
    function __construct() {
        $this->service = new MainService([
            'attributes' => [
                'manyToMany' => ['services', 'specializations']
            ],
            'model' => Doctor::class,
            'rightName' => 'doctor',
            'filter' => DoctorFilter::class
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
