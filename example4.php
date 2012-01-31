<?php
//In this example we load and run the task "HelloWorld" with verbose enabled

//Include the task manager into our program
require_once("./taskmanager/taskmanager.php");

//Initialize the Manager
$manager=new TaskManager();

//Turn verbose reporting on
$manager->verbose=true;

//Load the task "HelloWorld"
$manager->add_task(new HelloWorld());

//Make sure there are tasks present
if($manager->check_tasks()){
	//Run all loaded tasks
	$manager->run();
}
?>