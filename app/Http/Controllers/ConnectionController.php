<?php

namespace App\Http\Controllers;

use App\Services\ConnectionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Connection\CreateRequest;
use App\Http\Requests\Connection\FilterRequest;
use App\Http\Requests\Connection\UpdateRequest;
use App\Models\Connection;

class ConnectionController extends Controller
{
    function __construct(ConnectionService $service) {
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