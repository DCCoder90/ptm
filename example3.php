<?php
//In this example we load and run the task "HelloWorld" with forking enabled

//Include the task manager into our program
require_once("./taskmanager/container.php");

//Initialize the Manager with throttle enabled
$manager=new TaskManager(true);
$manager->verbose=true;
$manager->sim_par=1;
$manager->sleep=10;

//Load the task "HelloWorld" along with TRUE to enable forking 10 times
$i=0;
while($i<10){
	$manager->add_task(new HelloWorld(),TRUE);
	$i++;
}


//Make sure there are tasks present
if($manager->check_tasks()){
	//Run all loaded tasks
	$manager->run();
}
?>