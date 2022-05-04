<?php

namespace App\Http\Controllers;

use App\Services\ClinicService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Clinic\CreateRequest;
use App\Http\Requests\Clinic\FilterRequest;
use App\Http\Requests\Clinic\UpdateRequest;
use App\Services\MainService;

class ClinicController extends Controller
{
    function __construct($service) {
        $this->service = new MainService();
    }

    public function index(FilterRequest $request) {
        $data = $request->validated();
        
        return $this->service->select($data);
    }

    public function store(CreateRequest $request) {
        $data = $request->validated();

        return $this->service->create($data);
    }

    public function update(UpdateRequest $request) {
        $data = $request->validated();

        return $this->service->update($data);
    }
    
    public function destroy(DeleteRequest $request) {
        $data = $request->validated();

        return $this->service->delete($data);
    }   
}
