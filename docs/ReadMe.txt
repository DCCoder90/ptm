\\\\\\\\\\\\\\\\\\\\\\\\\\
///PTM - PhpTaskManager///
///Created: 2011-08-31 ///
///Author: Darkvengance///
///Version: 2.5        ///
///Updated: 2012-02-19 ///
\\\\\\\\\\\\\\\\\\\\\\\\\\
The PhpTaskManager is a task manager meant for use by larger more structured
PHP programs.  PTM has many useful functions currently built in and is capable
of managing many different tasks assigned to it with an "easy to use"
methodology.

Along with it's "case-by-case" forking functionality PTM also has an pseudo
internal memory, this allows tasks to store information intended for use by
other tasks, or for future use.

Please note that PhpTaskManager is NOT for use in web applications, it is meant
for use in CLI and GUI applications ONLY.


----------------
| Requirements |
----------------
*Only works with Linux based systems
*Must have pnctl extensions enabled

To enable pnctl extensions read the following instructions:
1) Make sure your /etc/apt/sources.list has a deb-src line. If it doesn't, duplicate a deb line and change "deb" to "deb-src", then apt-get update

2) Install the PHP development files:
$ apt-get install php5-dev
3) Go to some temporary directory and get the PHP source:
$ apt-get source php5
4) Build the pcntl module
$ cd php*/ext/pcntl
$ phpize
$ ./configure --prefix=/usr
$ make
$ make install

-----------------------
| Availible functions |
-----------------------
*Loading and unloading tasks
*Running Tasks
*Checking for loaded tasks
*Forking tasks
*Share memory among tasks
*"Throttle" function to only allow a set number of children tasks to spawn at once.
*Immediatley kill all active tasks

-----------------
| File Purposes |
-----------------
taskmanager/manager.task.php          - Task Manager
taskmanager/worker.task.php           - Worker
taskmanager/container.php             - Container
taskmanager/tasks/helloworld.task.php - Task


-----------
| Credits |
-----------
Darkvengance - Programmer/Developer
japon        - Debugging/Contributor
jQuery       - Debugging
neonspell    - Debugging/Contributor

------------------
| Special Thanks |
------------------
Thank you to everyone that has downloaded and is currently using
the Php Task Manager, also I have to thank all of those individuals
that have given me feedback.

--------------
| Disclaimer |
--------------
This program is served "as-is" and no garuntees are made with it.  If you need
any support with this or making modifications to it feel free to contact me
through the contact form on my website, or by sending an email to
<admin@rejectedfreaks.net>.  Please remember that this program is released under
the GPL License so if you use it in one of your programs you are required to release
the source code.

Please note that this program is in no way affiliated with the PHP and Zend
Engine developers.  This program is one of my own personal work with the help of
contributors mentioned in the credits.