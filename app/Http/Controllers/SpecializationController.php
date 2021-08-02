<?php

namespace App\Http\Controllers;

use App\Services\MainService;
use App\Models\Specialization;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Filters\SpecializationFilter;
use App\Http\Requests\Specialization\CreateRequest;
use App\Http\Requests\Specialization\FilterRequest;
use App\Http\Requests\Specialization\UpdateRequest;

class SpecializationController extends Controller
{
    function __construct() {
        $this->service = new MainService([
            'attributes' => [
                'manyToMany' => ['services', 'doctors'] 
            ],
            'model' => Specialization::class,
            'rightName' => 'clinic',
            'filter' => SpecializationFilter::class
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
