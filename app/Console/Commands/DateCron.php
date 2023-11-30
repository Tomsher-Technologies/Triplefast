<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Notifications;
use App\Models\SopcReports;
use App\Models\User;
use App\Jobs\SendMail;
use App\Mail\MailSend;

class DateCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'date:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job for due date (machining, heat treatment, S1, subcon,and stock dates)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reports = SopcReports::whereNotIn('job_status',['4','5'])
                                ->where('is_deleted', 0)
                                ->where('is_active', 1)
                                ->get();

        $not = [];
        if($reports){
            $notification = [];
            foreach($reports as $pack){
                $mach_date = $pack->machining;
                if($mach_date != ''){
                    $machdiff =  strtotime($mach_date)-strtotime(date("Y-m-d"));
                    $machdays = round($machdiff / (60 * 60 * 24));
                    if($machdays == 1){
                        $notification[] = "Machining date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                    }
                }

                $heat_date = $pack->heat_treatment;
                if($heat_date != ''){
                    $heatdiff =  strtotime($heat_date)-strtotime(date("Y-m-d"));
                    $heatdays = round($heatdiff / (60 * 60 * 24));
                    if($heatdays == 1){
                        $notification[] = "Heat treatment date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                    }
                }
                
                $target_date = $pack->target_date;
                if($target_date != ''){
                    $targetdiff =  strtotime($target_date)-strtotime(date("Y-m-d"));
                    $targetdays = round($targetdiff / (60 * 60 * 24));
                    if($targetdays == 1){
                        $notification[] = "Target date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                    }
                }

                // $s1_date = $pack->s1_date;
                // if($s1_date != ''){
                //     $s1diff =  strtotime("$s1_date")-strtotime(date("Y-m-d"));
                //     $s1days = round($s1diff / (60 * 60 * 24));
                //     if($s1days == 1){
                //         $notification[] = "S1 date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                //     }
                // }

                // $subcon_date = $pack->subcon;
                // if($subcon_date != ''){
                //     $subcondiff =  strtotime("$subcon_date")-strtotime(date("Y-m-d"));
                //     $subcondays = round($subcondiff / (60 * 60 * 24));
                //     if($subcondays == 1){
                //         $notification[] = "Subcon date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                //     }
                // }

                // $stock_date = $pack->stock;
                // if($stock_date != ''){
                //     $stockdiff =  strtotime("$stock_date")-strtotime(date("Y-m-d"));
                //     $stockdays = round($stockdiff / (60 * 60 * 24));
                //     if($stockdays == 1){
                //         $notification[] = "Stock date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                //     }
                // }
            }
            if(!empty($notification)){
                
                $notify = [];
    
                $mailContent['subject'] = "Tomorrow's due dates";
                $mailContent['message'] = $notification;
                $mailContent['extra']   = [];
    
                $notify_users = User::where('user_type','3')->where('is_deleted',0)->where('is_active',1)->get()->toArray();
               
                foreach($notify_users as $notuser){
                    foreach($notification as $not){
                        $notify[] = [
                            'user_id' => $notuser['id'],
                            'content' => $not,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                    }
                    if($notuser['email_notification'] == 1){
                        dispatch(new SendMail($notuser,$mailContent));
                    }
                }
    
                if(!empty($notify)){
                    Notifications::insert($notify);
                }
            }
        }
    }
}
