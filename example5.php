<?php
//In this example we load and run the task "HelloWorld"

//Include the task manager into our program
require_once("./taskmanager/container.php");

//Initialize the Manager
$manager=new TaskManager();
$manager->verbose=true;

//Load the "Hello World" task
$manager->add_task(new HelloWorld());

//Load the "Hello World2" task which pulls
//the first word from the internal memory.
$manager->add_task(new HelloWorld2());

//Make sure there are tasks present
if($manager->check_tasks()){
	//Run all loaded tasks
	$manager->run();
}
?>
