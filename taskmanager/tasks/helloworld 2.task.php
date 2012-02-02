<?php
class HelloWorld2 extends Task{
	function run(){
		$data=$this->share_memory("GET","HelloWorld",0);
		echo $data." world!\n";
	}
}
?>
