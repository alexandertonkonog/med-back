<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DoctorService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\CreateRequest;
use App\Http\Requests\Doctor\FilterRequest;

class DoctorController extends Controller
{
    function __construct(DoctorService $service) {
        $this->service = $service;
    }

    public function select(FilterRequest $request) {
        $data = $request->validated();

        return $this->service->select($data);
    }

    public function create(CreateRequest $request) {
        $data = $request->validated();

        return $this->service->create($data, $request);
    }

    public function upsert(FilterRequest $request) {
        $data = $request->validated();

        return $this->service->doctors($data);
    }
}
