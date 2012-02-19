<?php
error_reporting(0);

/**
 * get_tasks()
 * * Grabs all tasks in the "tasks" directory and loads them into memory *
 * @return array
 */
function get_tasks($cwd){
	$tasks=array();
	$err=array();
	if ($h = opendir($cwd)) {
		while (false !== ($file = readdir($h))) {
			if($file!="."&&$file!=".."){
				$tasks[]=$file;
			}
		}
		closedir($h);
		return $tasks;
	}else{
		$err[]=FALSE;
		$err[]="Error opening tasks directory!";
		return $err;
	}
}

$cwd=getcwd();
$cwd=$cwd."/taskmanager/tasks";
$r=get_tasks($cwd);
if($r[0]==FALSE){
	echo $err[1];
}else{
	include("manager.task.php");
	include("worker.task.php");
	foreach($r as $task){
		include($cwd."/".$task);
	}
}
?>
