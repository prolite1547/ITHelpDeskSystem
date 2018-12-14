<?php

    use App\Category;
use App\Ticket;
use App\User;

if (! function_exists('selectArray')) {
        function selectArray($group,$model){
            $category = $model::find($group);
            if(!$category) return [null => 'N/A'];

            $categories = $category->categories;

            $select = [];
            foreach ($categories as $category) {
                $select = array_add($select,$category->id,$category->name);
            }


            return $select;
        }
    }

    if (! function_exists('lookupCategories')) {
        //iterates array and look up the id to the categories table to get the value
        function lookupCategories($array){

            $lookupCategories = [];
            foreach ($array as $key => $value) {
                if($data = Category::find($value)){
                    $lookupCategories[$key] = $data;
                }
            }

            return $lookupCategories;
        }
    }

    if (! function_exists('groupListSelectArray')) {
        function groupListSelectArray($model,$groupName,$relationship,$value,$name){

            $records = $model::with($relationship)->get();

            $dataArray = [];
            foreach ($records as $row){
                $dataArray[$row->$groupName] = $row->$relationship->pluck($name,$value)->toArray();
            }

            return $dataArray;
        }


    }

if (! function_exists('tickeyTypeCount')) {
    function tickeyTypeCount($type,$id = ''){

        if($type === 'all'){
            $tickets = Ticket::all();
        }elseif($type === 'status'){
            $tickets = Ticket::whereStatus($id)->get();
        }elseif($type === 'user'){
            $tickets = User::find($id)->assignedTickets;
        }

        $ticketCount = $tickets->count();
        $incident = $request = $others = 0;
        foreach ($tickets as $ticket){
            if($ticket->type === 1){
                $incident++;
            }elseif ($ticket->type === 2){
                $request++;
            }else{
                $others++;
            }
        }

        return compact('incident','request','ticketCount');
    }
}
?>
