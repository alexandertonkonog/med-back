<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpecializationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Specialization\CreateRequest;
use App\Http\Requests\Specialization\FilterRequest;
use App\Http\Requests\Specialization\UpdateRequest;

class SpecializationController extends Controller
{
    function __construct(SpecializationService $service) {
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
