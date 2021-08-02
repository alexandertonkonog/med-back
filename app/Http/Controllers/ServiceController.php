<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ServiceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Service\CreateRequest;
use App\Http\Requests\Service\FilterRequest;
use App\Http\Requests\Service\UpdateRequest;

class ServiceController extends Controller
{
    function __construct(ServiceService $service) {
        $this->service = $service;
    }

    public function select(FilterRequest $request) {
        $data = $request->validated();

        return $this->service->select($data);
    }

    public function create(CreateRequest $request) {
        $data = $request->validated();

        return $this->service->create($data);
    }

    public function update(UpdateRequest $request) {
        $data = $request->validated();

        return $this->service->update($data);
    }
    
    public function delete(DeleteRequest $request) {
        $data = $request->validated();

        return $this->service->delete($data);
    }   
}
