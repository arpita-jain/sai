<?php

//Categories
$catid = 0;

$all_cats = array('all');

$kategorien = get_categories(array('child_of' => 0,'orderby' => 'title','order' => 'ASC'));
foreach($kategorien as $kategorie) {
    $field = strtolower($kategorie->name);
    $all_cats[] = str_replace(" ", "-", $field);
}

$selected_cats = explode(", ", trim(get_option('frm_menu_bottom_order'), ','));

$tab_pages = explode(", ", trim(get_option('frm_menu_top_order'), ','));

$selected_cats_final = array();
foreach($selected_cats as $cat) {

    if(in_array(strtolower($cat), $all_cats)) {

        $selected_cats_final[] = strtolower($cat);

    }

}


$result = array_diff($all_cats, $selected_cats_final);

$cat_arr = array();
if(get_option('frm_menu_bottom_order') == "") {

    $cat_arr = $all_cats;

} else {

    $cat_arr = array_merge($selected_cats_final, $result);

}
