<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Services\MainService;
use App\Http\Filters\ConnectionFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Connection\CreateRequest;
use App\Http\Requests\Connection\FilterRequest;
use App\Http\Requests\Connection\UpdateRequest;

class ConnectionController extends Controller
{
    public function __construct() {
        $this->service = new MainService([
            'attributes' => [
                'manyToMany' => [] 
            ],
            'model' => Connection::class,
            'rightName' => 'connection',
            'filter' => ConnectionFilter::class
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
