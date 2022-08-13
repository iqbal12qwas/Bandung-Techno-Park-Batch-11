<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ActivityRepository;
use App\Traits\ReturnJson;


class ActivityController extends Controller
{
    use ReturnJson;

    protected $activityRepo;

    public function __construct(ActivityRepository $activity)
    {
        $this->activityRepo = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('activity');
    }

    public function activityList(Request $request)
    {
        try {
            $status = $request->status ?? '';
            $datas = $this->activityRepo->getActivityList($status);
            $result = ['message' => 'success', 'data' => $datas];
            return $this->returnJsonSuccess($result);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    public function getCountMonth()
    {
        try {
            $datas = $this->activityRepo->countMonth();
            $result = ['message' => 'success', 'data' => $datas];
            return $this->returnJsonSuccess($result);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }            
    }

    public function getCountMethod()
    {
        try {
            $datas = $this->activityRepo->countMethod();
            $result = ['message' => 'success', 'data' => $datas];
            return $this->returnJsonSuccess($result);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }          
    }

}