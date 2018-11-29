<?php

    use App\Category;

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
?>
