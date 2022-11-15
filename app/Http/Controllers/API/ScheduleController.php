<?php

namespace App\Http\Controllers\API;

use App\Models\Schedule;
use App\Http\Controllers\API\BaseController as BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends BaseController
{
    public function getAll(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Schedule::query();

        if ($request->has('dentist_id')) {
            $query = $query->where(['dentist_id' => $request->dentist_id]);
        }

        if ($request->has('date')) {
            $query = $query->whereDate('date', '=', Carbon::parse($request->date));
        }

        if ($request->has('isDentist')) {
            $query = $query->where(['dentist_id' => auth('sanctum')->user()->id]);
        }

        $data = $query->get();

        return $this->sendResponse($data, 'ok');
    }

    public function setSchedule(Request $request): \Illuminate\Http\JsonResponse
    {
        $schedule = new Schedule();
        $schedule->client_id = auth('sanctum')->user()->id;
        $schedule->dentist_id = $request->dentist_id;
        $schedule->service_id = $request->service_id;
        $schedule->status_id = 1;
        $schedule->date = Carbon::parse($request->date);
        $schedule->hour = $request->hour;
        $schedule->save();

        return $this->sendResponse($schedule, 'ok');
    }

    public function updateSchedule(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $schedule = Schedule::query()->where(['id' => $id])->first();
        $schedule->status_id = $request->status_id;
        $schedule->update();

        return $this->sendResponse($schedule, 'ok');
    }
}
