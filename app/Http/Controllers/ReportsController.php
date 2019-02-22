<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Category;
use App\Incident;
use App\Ticket;
use App\Call;
use App\Resolve;
use App\CategoryA;
use App\CategoryB;
use App\Store;
use Illuminate\Support\Facades\Auth;


class ReportsController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reports(){
        return view('reports.reports', ['users'=> User::all(), 'categories'=> CategoryA::all(), 'stores'=> Store::all()]);
    }

    public function generateIPP(Request $request){
        $ticket_logged = 0;
        $start = date('Y-m-d', strtotime($request->start)) . " 00:00:00";
        $end = date('Y-m-d', strtotime($request->end)). " 23:59:59";

        // $user = User::where('id', '=', $request->user_id)->get();
        $TicketUserLogged = Call::where('user_id', $request->user_id)->whereBetween('created_at', [$start, $end])->get();

        $rowdata ="";
        $data = "<table id='demo-dt-basic' class='table table-striped table-bordered table-hover IPPTable' cellspacing='0' width='100%'>";
            $data .= "<thead style='font-size:14px;'>";
                $data .= "<tr><th>Ticket title</th><th>Resolved</th><th>No. of Days/Hrs Resolved</th></tr>";
            $data .= "</thead>";
            $data .= "<tbody style='font-size:12px;'>";
                   
                       foreach($TicketUserLogged as $logs){
                               
                                if(isset($logs->incident->ticket->resolve->created_at)){
                                    $resolved = "YES";
                                        $resdate = date('m/d/y | H:i:s A', strtotime($logs->incident->ticket->resolve->created_at));
                                        $date1 = date_create(date('Y-m-d H:i:s', strtotime($logs->incident->ticket->created_at)));
                                        $date2 = date_create(date('Y-m-d H:i:s', strtotime($logs->incident->ticket->resolve->created_at)));
                                        $diff = date_diff($date1,$date2);
                                    
                                        if((int)$diff->format("%a") == 0){
                                            $resinterval =  $diff->format("%h Hour(s) %i Minute(s) %s Second(s)");
                                        }else{
                                            $resinterval =  $diff->format("%a Day(s)");
                                        }
                                }else{
                                    $resolved = "NO";
                                    $resinterval = "N/A";
                                }

                               
                                    $rowdata .= "<tr><td>". $logs->incident->subject ."</td><td>".  $resolved ."</td><td>". $resinterval."</td>";
                                    $ticket_logged +=1;
                                }   
                                    
                       
                  
                         $data .= $rowdata;
            $data .= "</tbody>";
        $data .= "</table>";


        return response()->json(array('success'=>true, 'ippdata'=>$data, 'ticket_logged'=>$ticket_logged), 200);
    }



    public function generateIPC(Request $request){
        // $users = User::all();
        //  $incidents = Incident::all();
        // Reservation::whereBetween('reservation_from', [$from, $to])->get();

        if($request->category == "all"){
            $incidents = Incident::whereYear('created_at', '=', $request->year)
            ->whereMonth('created_at', '=', $request->month)
            ->get();
        }else{
            $incidents = Incident::whereYear('created_at', '=', $request->year)
            ->whereMonth('created_at', '=', $request->month)
            ->where('catA', $request->category)
            ->get();
        }

        $rowdata ="";
        $data = "<table id='demo-dt-basic' class='table table-striped table-bordered table-hover IPCTable' cellspacing='0' width='100%'>";
            $data .= "<thead style='font-size:14px;'>";
                $data .= "<tr><th>Category</th><th>Ticket ID</th><th>Status</th></tr>";
            $data .= "</thead>";
            $data .= "<tbody style='font-size:12px;'>";
                    foreach($incidents as $incident){
                        if(isset($incident->ticket->id)){
                            $status = strtoupper($incident->ticket->statusRelation->name);
                         $rowdata .= "<tr><td>".$incident->catARelation->name."</td><td>"."TID".$incident->ticket->id."</td><td>".$status."</td></tr>"; 
                        }       
                    }
                         $data .= $rowdata;
            $data .= "</tbody>";
        $data .= "</table>";


        return response()->json(array('success'=>true, 'ipcdata'=>$data), 200);
    }

    public function generateILR(Request $request){
        $category = $request->category;
        $status1 = $request->status;
        $start = date('Y-m-d', strtotime($request->start)) . " 00:00:00";
        $end = date('Y-m-d', strtotime($request->end)). " 23:59:59";
        $resdate = "N/A";
        $pendingDuration = "Resolved";
        $resinterval = "N/A";
        $countRow = 0;
        $countResolved = 0;

      
        if($category != "all"){
            $incidents = Incident::whereBetween('created_at', [$start, $end])->where('catA', $category)->get();
        }else{
            $incidents = Incident::whereBetween('created_at', [$start, $end])->get();
        }

        $rowdata ="";
        $data = "<table id='demo-dt-basic' class='table table-striped table-bordered table-hover ILRTable' cellspacing='0' width='100%'>";
            $data .= "<thead style='font-size:14px;'>";
            if($status1 == "all"){
                $data .= "<tr><th>Ticket ID</th><th>Subject</th><th>Category</th><th>Logged Date</th><th>No. of Days/Hrs Pending</th><th>Resolved Date</th><th>No. of Days/ Hrs. Resolved</th><th>Assigned to</th><th>Status</th></tr>";
            }elseif($status1 == "resolved"){
                $data .= "<tr><th>Ticket ID</th><th>Subject</th><th>Category</th><th>Logged Date</th><th>Resolved Date</th><th>No. of Days/ Hrs. Resolved</th><th>Assigned to</th><th>Status</th></tr>";
            }else{
                $data .= "<tr><th>Ticket ID</th><th>Subject</th><th>Category</th><th>Logged Date</th><th>No. of Days/Hrs Pending</th><th>Assigned to</th><th>Status</th></tr>";
            }   
                
            $data .= "</thead>";
            $data .= "<tbody style='font-size:12px;'>";
                    foreach($incidents  as $incident){
                       if(isset($incident->ticket->id)){
                           $status = strtoupper($incident->ticket->statusRelation->name);
                           
                                if(isset($incident->ticket->resolve->created_at)){
                                    $resdate = date('m/d/y | H:i:s A', strtotime($incident->ticket->resolve->created_at));
                                    $date1 = date_create(date('Y-m-d H:i:s', strtotime($incident->ticket->created_at)));
                                    $date2 = date_create(date('Y-m-d H:i:s', strtotime($incident->ticket->resolve->created_at)));
                                    $diff = date_diff($date1,$date2);
                                
                                    if((int)$diff->format("%a") == 0){
                                        $resinterval =  $diff->format("%h Hour(s) %i Minute(s) %s Second(s)");
                                    }else{
                                        $resinterval =  $diff->format("%a Day(s)");
                                    }
                                    $pendingDuration = "Resolved";
                            }else{
                                date_default_timezone_set("Asia/Manila");
                                $currentDate =  date('Y-m-d H:i:s');
    
                                $date1 = date_create(date('Y-m-d H:i:s', strtotime($incident->ticket->created_at)));
                                $date2 = date_create(date("Y-m-d H:i:s", strtotime($currentDate)));
                                $diff = date_diff($date1,$date2);

                                if((int)$diff->format("%a") == 0){
                                    $pendingDuration =  $diff->format("%h Hour(s) %i Minute(s) %s Second(s)");
                                }else{
                                    $pendingDuration =  $diff->format("%a Day(s)");
                                }

                            }
                           
                            if($status1 == "all"){
                                $rowdata .= "<tr><td>"."TID".$incident->ticket->id."</td><td>".$incident->subject."</td><td>".$incident->catARelation->name."</td><td>".date('m/d/y | H:i:s A', strtotime($incident->ticket->created_at))."</td><td>".$pendingDuration."</td><td>".$resdate."</td><td>".$resinterval."</td><td>".$incident->ticket->assigneeRelation->full_name."</td><td>".$status."</td></tr>";
                                $countRow +=1;
                                if(isset($incident->ticket->resolve->created_at)){
                                    $countResolved +=1;
                                }
                            }else{
                                if($status1 == "resolved" AND isset($incident->ticket->resolve->created_at)){
                                    $rowdata .= "<tr><td>"."TID".$incident->ticket->id."</td><td>".$incident->subject."</td><td>".$incident->catARelation->name."</td><td>".date('m/d/y | H:i:s A', strtotime($incident->ticket->created_at))."</td><td>".$resdate."</td><td>".$resinterval."</td><td>".$incident->ticket->assigneeRelation->full_name."</td><td>".$status."</td></tr>";
                                    $countRow +=1;
                                    $countResolved +=1;
                                }elseif($status1 == "unresolved" AND !isset($incident->ticket->resolve->created_at)){
                                    $rowdata .= "<tr><td>"."TID".$incident->ticket->id."</td><td>".$incident->subject."</td><td>".$incident->catARelation->name."</td><td>".date('m/d/y | H:i:s A', strtotime($incident->ticket->created_at))."</td><td>".$pendingDuration."</td><td>".$incident->ticket->assigneeRelation->full_name."</td><td>".$status."</td></tr>";
                                    $countRow +=1;
                                    $countResolved = 0;
                                }
                             } 
                            $resdate = "N/A";
                            $resinterval = "N/A";
                            }
                    }
                         $data .= $rowdata;
            $data .= "</tbody>";
        $data .= "</table>";

        return response()->json(array('success'=>true, 'ilrdata'=>$data, 'rowCount'=>$countRow, 'resolvedCount'=>$countResolved), 200);
    }

    public function generateRDS(Request $request){
        $start = date('Y-m-d', strtotime($request->start)) . " 00:00:00";
        $end = date('Y-m-d', strtotime($request->end)). " 23:59:59";
        $resdate = "N/A";
        $resinterval = "N/A";
        $rowdata ="";
        $store = $request->store;
       
        if($store == "all"){
            $incidents = Incident::whereBetween('created_at', [$start, $end])->where('catA', 6)->get();
        }else{
            $incidents = Incident::whereHas('ticket.getStore', function ($query) use ($store) {
                $query->where('id', '=',$store); 
            })->whereBetween('created_at', [$start, $end])->where('catA', 6)->get();
        }
            
        
        
        $data = "<table id='demo-dt-basic' class='table table-striped table-bordered table-hover RDSTable' cellspacing='0' width='100%'>";
        $data .= "<thead style='font-size:14px;'>";
             $data .= "<tr><th>Ticket ID</th><th>Description</th><th>Store</th><th>Category</th><th>Sub-Category</th><th>Logged Date</th><th>Resolved Date</th><th>No. of Days/ Hrs. Resolved</th><th>Status</th></tr>";
        $data .= "</thead>";
        $data .= "<tbody style='font-size:12px;'>";
             foreach($incidents  as $incident){
                if(isset($incident->ticket->id)){
                    $status = strtoupper($incident->ticket->statusRelation->name);
                        if(isset($incident->ticket->resolve->created_at)){
                            $resdate = date('m/d/y | H:i:s A', strtotime($incident->ticket->resolve->created_at));
                            $date1 = date_create(date('Y-m-d H:i:s', strtotime($incident->ticket->created_at)));
                            $date2 = date_create(date('Y-m-d H:i:s', strtotime($incident->ticket->resolve->created_at)));
                            $diff = date_diff($date1,$date2);
                        
                            if((int)$diff->format("%a") == 0){
                                $resinterval =  $diff->format("%h Hour(s) %i Minute(s) %s Second(s)");
                            }else{
                                $resinterval =  $diff->format("%a Day(s)");
                            }
                        }
                       
                               //  $rowdata .= "<tr><td>"."TID".$incident->ticket->id."</td><td>".$incident->subject."</td><td>".""."</td><td>".$incident->catARelation->name."</td><td>".""."</td><td>".date('m/d/y | H:i:s A', strtotime($incident->ticket->created_at))."</td><td>".$resdate."</td><td>".$resinterval."</td><td>".$status."</td></tr>";
                               $rowdata .= "<tr><td>"."TID".$incident->ticket->id."</td><td>".$incident->subject."</td><td>".$incident->ticket->getStore->store_name."</td><td>".$incident->catARelation->name."</td><td>".$incident->catBRelation->name."</td><td>".date('m/d/y | H:i:s A', strtotime($incident->ticket->created_at))."</td><td>".$resdate."</td><td>".$resinterval."</td><td>".$status."</td></tr>";
                     
                     
                }
             }
         $data .= $rowdata;
        $data .= "</tbody>";
        $data .= "</table>";
        return response()->json(array('success'=>true, 'rdsdata'=>$data), 200);

    }




                        //                //
                        // CHARTS REPORT  //
                        //                //


public function loadChart(){
      $categories = CategoryA::all();
      return view('reports.chart')->with('categories',$categories);
    }

    public function loadLVR(Request $request){

        $totalLogs = 0;
        $totalResolved = 0;

        $logs = array();
        $resolve = array();
        $incidents;
        
        $incidents = Incident::whereYear('created_at', '=', $request->year )
        ->whereMonth('created_at', '=', $request->month)
        ->get();             
        array_push($logs,  count($incidents));
      
        
        $resolves = Resolve::whereYear('created_at', '=', $request->year)
        ->whereMonth('created_at', '=', $request->month)
        ->get();             
        array_push($resolve,  count($resolves));
     
        for($log = 0;$log<count($logs); $log++){
            $totalLogs += $logs[$log];
        }

        for($res = 0; $res<count($resolve); $res++){
            $totalResolved +=  $resolve[$res];
        }
        
        return response()->json(array('success'=>true, 'logged'=>$logs, 'resolved'=>$resolve, 'totalLogged'=>$totalLogs, 'totalResolved'=>$totalResolved), 200);
    }

    public function loadIPCR(Request $request){ 
        $totalLogs = array();
        $totalResolved = array();
        $count = 0;
        $logs = 0;
        $resolves = 0;
        $category3 = array();
        $ovrlLogs = 0;
        $ovrlResolved = 0;
        $category = $request->category;
        
      if($category == "all"){
            $relation = "catARelation";
            $incidents = Incident::whereYear('created_at', '=', $request->year )
            ->whereMonth('created_at', '=', $request->month )
            ->get();
            $categories = CategoryA::orderBy('name','asc')->get();
      }else{
            $relation = "catBRelation";
            $incidents = Incident::whereYear('created_at', '=', $request->year )
            ->whereMonth('created_at', '=', $request->month )
            ->get();
            $categories = CategoryB::where('catA_id',$category)->orderBy('name','asc')->get();
      }
        
        foreach($categories as $category){
            array_push($category3, [$count,$category->name]);
            $count+=1;
        }

        for($i = 0; $i < count($category3); $i++){
            foreach($incidents as $incident){
                if($incident->$relation->name == $category3[$i][1]){
                        
                    if(isset($incident->ticket->resolve->created_at)){
                         $resolves+=1;
                         $ovrlResolved +=1;
                    }

                    $logs+=1;
                    $ovrlLogs +=1;
                }
            }
            
            array_push($totalLogs, [$i,$logs]);
            array_push($totalResolved, [$i,$resolves]);

            $logs= 0;
            $resolves = 0;
        }
       

        return response()->json(array('success'=>true, 'totalLogs'=>$totalLogs, 'totalResolved'=>$totalResolved, 'overallLogs'=>$ovrlLogs, 'overallResolved'=> $ovrlResolved , 'categories'=>$category3), 200);
    }

    public function loadTR(Request $request){

        $year  =  $request->year;
        $month =  $request->month;
         
        
        $users = User::all();
        $resolvers = array();
        $count =0;

        $topresolvers = array();
        $solveCount = array();
        $supports = array();
         
        $resolvers = User::whereHas('resolved')->withCount(['resolved'=>function($query) use ($year, $month){
            $query->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
        }])->orderBy('resolved_count', 'desc')->limit(10)->get();

        
        // User::whereHas('resolved')->withCount(['resolved'=>function($query){
        //     $query->whereYear('created_at', '=', '2019')->whereMonth('created_at', '=', '1');
        // }])->orderBy('resolved_count', 'desc')->limit(10)->first();
        
        // $resolvers = User::withCount(['resolved'=>function($query) use ($year, $month){
        //     $query->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
        // }])->orderBy('resolved_count', 'desc')->limit(10)->get();

        
        foreach($resolvers as $resolver){
            $rank = $count+1;
            array_push($topresolvers,[$count,  $resolver->full_name]);
            array_push($solveCount,[$count, $resolver->resolved_count]);

            foreach($resolver->resolved as $resolvedTickets){
                array_push($supports, [$count, $resolvedTickets->ticket->userLogged->id, $resolvedTickets->ticket->userLogged->full_name]);
            }

            $count+=1;
        }
        return response()->json(array('success'=>true, 'topresolvers'=>$topresolvers, 'solveCount'=>$solveCount, 'supports'=>$supports), 200);
    }

 

}

 