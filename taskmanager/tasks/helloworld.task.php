<?php
class HelloWorld extends Task{
	function run(){
		echo "Hello World!\n";
		$this->share_memory("POST","Goodbye",0);
	}
}
?>
