<?php

    use App\CategoryGroup;

    if (! function_exists('selectArray')) {
        function selectArray($group){

            $categories = CategoryGroup::findOrFail($group)->categories;
            if(!$categories) return 'No Output';
            $select = [];
            foreach ($categories as $category) {
                $select = array_add($select,$category->value,$category->name);
            }


            return $select;
        }
    }
?>
