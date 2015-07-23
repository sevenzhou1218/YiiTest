<?php

$arr = array(
	'A'=>array(
		'B'=>array(
			'C'=>'aa'
		),
		'D'=>array(
			'E'=>'dd'
		)
	)
);


function test(&$node, &$return)
{
    if(!is_array($node)){
        return false;
    }else{
		array_push($return,array_keys($node));
        foreach($node as $k=>&$v){
			test($v, $return);
			unset($v);
        }
		return true;
    }
    return false;
}

$retv = array();
$r = test($arr, $retv);
print_r($retv);
