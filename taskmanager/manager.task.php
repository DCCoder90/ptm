<?php
/**
 * TaskManager
 *
 * @package PTM
 * @author Darkvengance
 * @copyright Copyright (c) 2011
 * @version $Id$
 * @access public
 */
class TaskManager{
	protected $task_pool;
	protected $fork_pool;
	protected $task_queue;
	protected $fork_queue;
	protected $throttle;
	protected $cust_memfile;

	public $sim_par;
	public $sleep;
	public $verbose;

	/**
	 * TaskManager::__construct()
	 * * Initializes the class variables *
	 */
	public function __construct($throttle=false,$cust_memfile=""){
		$this->task_pool=array();
		$this->fork_pool=array();
		$this->task_queue=array();
		$this->fork_queue=array();

		$this->cust_memfile=$cust_memfile;

		$this->throttle=$throttle;
		$this->sim_par=5;
		$this->sleep=2;
		$this->verbose=false;
		//Check if pnctl extension is loaded, if not try to load it.
		if(!extension_loaded("pcntl")){
			if(!dl('pcntl.so')){
				die("ERROR: Could not load the pnctl extension!\n");
			}
		}
	}

	/**
	 * TaskManager::add_task()
	 * * Adds a task to the pool and returns the task key *
	 * @return int
	 */
	public function add_task($task,$fork=FALSE){
		$this->task_pool[]=$task;
		$this->fork_pool[]=$fork;
		$key=array_search($task,$this->task_pool);
		if($this->verbose==true){
			echo "Manager: Task '".$key."' added to pool.\n";
		}
		return $key;
	}

	/**
	 * TaskManager::check_tasks()
	 * * Checks if any tasks are in the pool *
	 * @return bool
	 */
	public function check_tasks(){
		if($this->verbose==true){
			echo "Manager: Checking for tasks in pool.\n";
		}
		if(empty($this->task_pool)){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/**
	 * TaskManager::remove_task()
	 * * Removes a task from the pool *
	 * @return bool
	 */
	public function remove_task($task,$key=false){
		if($key==false){
			$key=get_task_key($task);
			unset($this->task_pool[$key]);
			unset($this->fork_pool[$key]);
		}else{
			unset($this->task_pool[$task]);
			unset($this->fork_pool[$task]);
		}
		if($this->verbose==true){
			echo "Manager: Task '".$task."' removed from pool.\n";
		}
		return true;
	}

	/**
	 * TaskManager::run()
	 * * Runs all tasks in the pool *
	 * @return bool
	 */
	public function run(){
		foreach($this->task_pool as $task){
			$key=$this->get_task_key($task);

			//Add task to the queue
			$this->task_queue[$key]=$task;
			$this->fork_queue[$key]=$this->fork_pool[$key];
			if($this->verbose==true){
				echo "Manager: Task '".$key."' added to queue.\n";
			}
			//Remove task from the pool
			$this->remove_task($key,true);

			//Check if task is suppose to fork
			if($this->check_fork($key)==true){
				//If yes then see how many tasks are already forked
				$fork_que=$this->count_fork();
				//If it is over the maximum number, sleep until they
				//die
				while($fork_que[1]>=$this->sim_par){
					if($this->verbose==true){
						echo "Manager: Maximum number of forked tasks currently running, going to sleep.\n";
					}
					$fork_que=$this->count_fork();
					sleep($this->sleep);
				}
				if($this->verbose==true){
					echo "Manager: Enough children have died, proceeding to run task.\n";
				}
			}
			if($this->verbose==true){
				echo "Manager: Currently Running Task with key ".$key."\n";
			}
			//Run task
			$task->verbose=$this->verbose;
			$task->memfile=$this->cust_memfile;
			$task->fork($this->fork_queue[$key]);
		}

		while(1){
			$pid=pcntl_wait($extra);
			if($pid==-1){
				break;
			}
			$this->finish_task($pid);
		}
	}

	/**
	 * TaskManager::check_fork()
	 *  * Checks if the task is suppose to fork or not*
	 * @return bool
	 */
	public function check_fork($key){
		return $this->fork_pool[$key];
	}

	/**
	 * TaskManager::count_fork()
	 *  *Counts the number of forking tasks in the pool and queue*
	 * @return array
	 */
	public function count_fork(){
		$p=0;
		$q=0;

		foreach($this->fork_pool as $fork){
			if($task==true){
				$p++;
			}
		}

		foreach($this->fork_queue as $fork){
			if($task==true){
				$q++;
			}
		}

		if($this->verbose==true){
			echo "Manager: Checking for forking tasks\nIn Pool:".$p."\nIn Queue:".$q."\n\n";
		}

		$return=array($p,$q);
		return $return;
	}

	/**
	 * TaskManager::remove_queue()
	 * * Removes a task from the queue *
	 * @return bool
	 */
	protected function remove_queue($task){
		$key=get_task_key($task,true);
		unset($this->task_queue[$key]);
		unset($this->fork_queue[$key]);
		if($this->verbose==true){
			echo "Manager: Task '".$key."' removed from queue.\n";
		}
		return true;
	}

	/**
	 * TaskManager::get_task_key()
	 *  * Finds and returns a tasks key from the pool or queue *
	 * @return int
	 */
	protected function get_task_key($task,$queue=false){
		if($queue==true){
			$key=array_search($task,$this->task_queue);
		}else{
			$key=array_search($task,$this->task_pool);
		}
		return $key;
	}

	/**
	 * TaskManager::finish_task()
	 * * Finishes up a running task *
	 * @return bool
	 */
	protected function finish_task($pid){
		if($this->verbose==true){
			echo "Manager: Finishing task. PID:".$pid."\n";
		}
		if($task=$this->pid_to_task($pid)){
			$task->finish();
			$this->remove_queue($task);
			return true;
		}else{
			return false;
		}
	}

	/**
	 * TaskManager::pid_to_task()
	 * * Checks if the pid matches the task and checks if the task is still running *
	 * @return bool
	 */
	protected function pid_to_task($pid){
		foreach($this->task_pool as $task){
			if($task->pid()==$pid){
				return $task;
			}
		}
		return FALSE;
	}
}
?>
