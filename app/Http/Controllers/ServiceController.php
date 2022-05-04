<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\MainService;
use App\Http\Filters\ServiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Service\CreateRequest;
use App\Http\Requests\Service\FilterRequest;
use App\Http\Requests\Service\UpdateRequest;

class ServiceController extends Controller
{
    function __construct() {
        $this->service = new MainService([
            'attributes' => [
                'manyToMany' => ['doctors', 'specializations'] 
            ],
            'model' => Service::class,
            'rightName' => 'service',
            'filter' => ServiceFilter::class
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
