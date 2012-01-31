<?php
//In this example we load a task and then
//proceed to unload it based on the key.

//Include the task manager into our program
require_once("./taskmanager/container.php");

//Initialize the Manager
$manager=new TaskManager();

//Load the task "HelloWorld" and save the key
$key=$manager->add_task(new HelloWorld());

//Remove the task "HelloWorld"
$manager->remove_task($key,true);

//Check if there are any tasks in the pool
if($manager->check_tasks()){
	echo "Tasks present in the pool";
}else{
	echo "No Tasks in the pool";
}
?>
