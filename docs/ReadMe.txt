\\\\\\\\\\\\\\\\\\\\\\\\\\
///PTM - PhpTaskManager///
///Created: 2011-08-31 ///
///Author: Darkvengance///
///Version: 2.1        ///
///Updated: 2011-10-17 ///
\\\\\\\\\\\\\\\\\\\\\\\\\\
The PhpTaskManager is a simple task manager meant for use by larger more structured
PHP programs.  PTM has many useful functions currently built in and is capable of
managing many different tasks assigned to it with an "easy to use" methodology.

Along with it's "case-by-case" forking functionality PTM also has an internal memory,
this allows tasks to store information intended for use by other tasks.

Please note that PhpTaskManager is not for use in web applications, it is meant
for use in CLI and GUI applications ONLY.


----------------
| Requirements |
----------------
*Only works with Linux based systems
*Must have pcntl extensions enabled

-----------------------
| Availible functions |
-----------------------
*Loading and unloading tasks
*Running Tasks
*Checking for loaded tasks
*Forking tasks
*Share memory among tasks
*"Throttle" function to only allow a set number of children tasks to spawn at once.

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