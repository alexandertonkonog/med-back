<?php

namespace App\Http\Controllers;

use App\Services\ClinicService;
use App\Http\Controllers\Controller;
use App\Http\Filters\ClinicFilter;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Clinic\CreateRequest;
use App\Http\Requests\Clinic\FilterRequest;
use App\Http\Requests\Clinic\UpdateRequest;
use App\Models\Clinic;
use App\Services\MainService;

class ClinicController extends Controller
{
    function __construct() {
        $this->service = new MainService([
            'attributes' => [
                'manyToMany' => [] 
            ],
            'model' => Clinic::class,
            'rightName' => 'clinic',
            'filter' => ClinicFilter::class
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
