<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRef;
use App\Services\MainService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Connection\CreateRequest;
use App\Http\Requests\Connection\FilterRequest;
use App\Http\Requests\Connection\UpdateRequest;

class ConnectionRefController extends Controller
{
    function __construct() {
        $this->service = new MainService([
            'attributes' => [
                'manyToMany' => [] 
            ],
            'model' => ConnectionRef::class,
            'rightName' => 'ref',
            'filter' => ConnectionRefFilter::class,
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
