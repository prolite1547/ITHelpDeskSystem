<?php

    use App\CategoryGroup;
    use App\Category;

    if (! function_exists('selectArray')) {
        function selectArray($group){

            $categories = CategoryGroup::findOrFail($group)->categories;
            if(!$categories) return 'No Output';
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
?>
