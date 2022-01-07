<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Trip;
use App\Http\Resources\TripResource;

class TripController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth.apikey');
    }
    
    public function index()
    {
        try {
            $data = Cache::remember("trip_all", 10 * 60, function () {
                return Trip::all();
            });
            return $this->sendResponse(TripResource::collection($data), 'Data fetched sucessfully');
        } catch (\Throwable $e) {
            return $this->sendError('Unauthorized', $e, 401);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'title' => 'required',
                'origin_id' => 'required|integer',
                'destination_id' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'trip_types_id' => 'required|integer',
                'description' => 'required'
            ]);

            if ($validated->fails()) {
                return $this->sendError('Required field cannot be empty!', $validated->errors(), 401);
            } else {
                $insert = Trip::create($request->all());

                if ($insert) {
                    $forget = Cache::flush();
                    $data = Trip::findOrFail($insert->id);
                    return $this->sendResponse($data, 'Data saved sucessfully');
                } else {
                    return $this->sendError('Unauthorized to Input data', '', 401);
                }
            }
        } catch (Exception $t) {
            return $this->sendError('Unauthorized', $t, 401);
        }
    }

    public function show($id)
    {
        try {
            $data = Cache::remember("trip_{$id}", 10 * 60, function () use ($id) {
                return Trip::where('id', $id)->get();
            });
            return $this->sendResponse(TripResource::collection($data), 'Data fetched sucessfully');
        } catch (\Throwable $e) {
            return $this->sendError('Unauthorized', $e, 401);
        }
    }

    public function edit($id)
    {
        try {
            $data = Trip::findOrFail($id);
            return $this->sendResponse($data, 'Data fetched sucessfully');
        } catch (\Throwable $e) {
            return $this->sendError('Unauthorized', $e, 401);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = Validator::make($request->all(), [
                'title' => 'required',
                'origin_id' => 'required|integer',
                'destination_id' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'trip_types_id' => 'required|integer',
                'description' => 'required'
            ]);

            if ($validated->fails()) {
                return $this->sendError('Required field cannot be empty!', $validated->errors(), 401);
            } else {
                $trip = Trip::findOrFail($id);
                $trip->update($request->all());

                if ($trip) {
                    $forget = Cache::flush();
                    $data = Trip::findOrFail($id);
                    return $this->sendResponse($data, 'Data updated sucessfully');
                } else {
                    return $this->sendError('Unauthorized to update data', '', 401);
                }
            }
        } catch (Exception $e) {
            return $this->sendError('Unauthorized', $e, 401);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = Trip::find($id)->delete();
            if ($delete) {
                $forget = Cache::flush();
                return $this->sendResponse('', 'Data deleted sucessfully');
            } else {
                return $this->sendError('Unauthorized to delete data', '', 401);
            }
        } catch (\Throwable $e) {
            return $this->sendError('Unauthorized', $e, 401);
        }
    }
}
