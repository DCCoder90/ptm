<?php
/**
 * Task
 *
 * @package PTM
 * @author Darkvengance
 * @copyright Copyright (c) 2011
 * @version $Id$
 * @access public
 */
class Task {
	protected $pid;
	protected $ppid;
	public $verbose;

	/**
	 * Task::fork()
	 * * Runs the task assigned to it *
	 * @return
	 */
	public function fork($fork=FALSE){

		if($fork==TRUE){
			if($this->verbose==true){
				echo "Worker: Forking enabled for current task.\n";
			}
			$pid=pcntl_fork();

			if($pid==-1){
				throw new Exception('fork error on Task object');
			}elseif($pid){
				#parent class
				$this->pid=$pid;
			}else{
				#child class
				$this->get_ids();
				$this->run();
				exit(1);
			}
		}else{
			if($this->verbose==true){
				echo "Worker: Forking disabled for current task.\n";
			}
			$this->get_ids();
			$this->run();
		}
	}

	/**
	 * Task::get_ids()
	 * * Collects the process IDs *
	 * @return
	 */
	public function get_ids(){
		#child
		$this->ppid=posix_getppid();
		$this->pid=posix_getpid();
	}

	/**
	 * Task::pid()
	 * * Returns the process ID *
	 * @return int
	 */
	public function pid(){
		if($this->verbose==true){
			echo "Worker: Task PID: ".$this->pid."\n";
		}
		return $this->pid;
	}

	/**
	 * Task::share_memory()
	 * * Interacts with the taskmanager's internal memory *
	 * @return mixed
	 */
	public function share_memory($method="COUN",$arg1="",$arg2="",$arg3=""){
		$task_name=get_class($this);
		if($this->verbose==true){
			echo "Worker: Accessing internal memory. Method: ".$method."\n";
		}
		$memfile="./taskmanager/memory";

		switch($method){

			case "CLEA":
				$memory=file_get_contents($memfile);
				$memory=unserialize($memory);

				unset($memory[$task_name]);

				$fh=fopen($memfile,"a+");
				$memory=serialize($memory);
				ftruncate($fh,0);
				fwrite($fh,$memory);
				fclose($fh);
				return true;
			break;

			case "COUN":
				$memory=file_get_contents($memfile);
				$memory=unserialize($memory);

				$t=count($memory);
				$i=count($memory, COUNT_RECURSIVE);
				$count=$i-$t;
				return $count;
			break;

			case "ERAS":
				$fh=fopen($memfile,"a+");
				ftruncate($fh,0);
				fclose($fh);
				return true;
			break;

			case "GET":
				if($arg1=="self"||$arg1=="this"){
					$arg1=$task_name;
				}
				$fh=fopen($memfile,"r");
				$memory=unserialize(fread($fh,filesize($memfile)));
				fclose($fh);


				if(array_key_exists($arg2,$memory[$arg1])){
					$data=$memory[$arg1][$arg2];
					return $data;
				}else{
					return false;
				}
			break;

			case "POST":
				$memory=file_get_contents($memfile);
				$memory=unserialize($memory);

				if(isset($arg2)&&$arg2!==""){
					$memory[$task_name][$arg2]=$arg1;
					$key=$arg2;
				}else{
					$memory[$task_name][]=$arg1;
					$key=array_search($arg1,$memory[$task_name]);
				}

				$fh=fopen($memfile,"a+");
				$memory=serialize($memory);
				ftruncate($fh,0);
				fwrite($fh,$memory);
				fclose($fh);
				return $key;
			break;

			case "EDIT":
				$memory=file_get_contents($memfile);
				$memory=unserialize($memory);

				$memory[$arg1][$arg2]=$arg3;

				$fh=fopen($memfile,"a+");
				$memory=serialize($memory);
				ftruncate($fh,0);
				fwrite($fh,$memory);
				fclose($fh);
				return true;
			break;

		}
	}

}
?>
