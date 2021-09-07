<?php



function fliterResults($filter)
{
    dd($filter);
}


function paginator($items)
{
    $page=request()->page;
       
    
    
    if($page==1||!$page){
        $index=0;
    }
    else $index=($page-1)*$items;

    return $index;

}