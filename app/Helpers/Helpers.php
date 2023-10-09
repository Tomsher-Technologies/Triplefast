<?php
  
use Carbon\Carbon;
use App\Models\User;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;


/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

if (!function_exists('openActiveRoutes')) {
    function openActiveRoutes(array $routes, $output = "open")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

if (!function_exists('getTimeSlotHrMIn')) {
    function getTimeSlotHrMIn($interval, $start_time, $end_time)
    {
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $i=0;
        $time = [];
        while(strtotime($startTime) <= strtotime($endTime)){
            $start = $startTime;
            $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $i++;
            if(strtotime($startTime) <= strtotime($endTime)){
                $time[$i] = date('g:i A', strtotime($start)).' - '.date('g:i A', strtotime($end));
            }
        }
        return $time;
    }
}

function generateUniqueCode() {
    $code = 'HK'.mt_rand(100000, 999999);
    if (uniqueCodeNumberExists($code)) {
        return generateUniqueCode();
    }
    return $code;
}

if (!function_exists('getNotifications')) {
    function getNotifications(){

        $notCount = Notifications::where('user_id', Auth::user()->id)->where('is_read',0)->count();

        $nots = Notifications::where('user_id', Auth::user()->id)
                                ->orderBy('created_at','DESC')
                                ->limit(3)->get()->toArray();

        $data['count'] = $notCount;
        $data['notifications'] = $nots;
        return $data;
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($timestamp){
        $timeAgo = Carbon::parse($timestamp)->diffForHumans();

        return $timeAgo;
    }
}




