<?php
//In this example we load and run the task "HelloWorld" with forking enabled

//Include the task manager into our program
require_once("./taskmanager/taskmanager.php");

//Initialize the Manager with throttle enabled
$manager=new TaskManager(true);

//Load the task "HelloWorld" along with TRUE to enable forking 10 times
for($i=0;$i>10;$i++){
	$manager->add_task(new HelloWorld(),TRUE);
}


//Make sure there are tasks present
if($manager->check_tasks()){
	//Run all loaded tasks
	$manager->run();
}
?>