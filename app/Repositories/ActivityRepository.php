<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\MonthModel;
use App\Models\MethodModel;
use Carbon\Carbon;
use DB;

class ActivityRepository 
{
    public function getActivityList(string $status = '')
    {
        $data = DB::connection('pgsql')->table('tb_activities')
                             ->join('tb_months', 'tb_months.id', '=', 'tb_activities.id_months')
                             ->join('tb_methods', 'tb_methods.id', '=', 'tb_activities.id_methods')
                             ->select('tb_activities.id as id_activity', 'id_methods', 'tb_methods.name as name_methods', 'id_months', 'tb_months.name as name_months', 'activity', 'date_start', 'date_end')
                             ->where('is_deleted', false)
                             ->orderBy('id_methods', 'ASC')
                             ->orderBy('id_months', 'ASC')
                             ->orderBy('date_start', 'ASC');

        if ($status == 'Berlangsung') {
            $data = $data->whereDate('date_start', Carbon::today());
        } else if ($status == 'Selesai') {
            $data = $data->whereDate('date_start', '<', Carbon::today());
        } else if ($status == 'Akan Datang') {
            $data = $data->whereDate('date_start', '>', Carbon::today());
        } 

        $data = $data->get();

        return $data;
    }

    public function countMonth()
    {
        $data = MonthModel::select(DB::raw('COUNT(*) as total_month'))->first();

        return $data;
    }

    public function countMethod()
    {
        $data = MethodModel::select(DB::raw('COUNT(*) as total_method'))->first();

        return $data;
    }
}
