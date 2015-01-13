
CONTENTS OF THIS FILE
---------------------

 * Prerequisites 
 * Installation
 * Creating the first module

PREREQUISITES
-------------

- A web server. Apache (version 2.0 or greater) is recommended.
- PHP 5.2.4 (or greater) (http://www.php.net/).
- One of the following databases:
  - MySQL 5.0.15 (or greater) (http://www.mysql.com/).
  - MariaDB 5.1.44 (or greater) (http://mariadb.org/). MariaDB is a fully compatible drop-in replacement for MySQL.
- DOJO 1.6 (or greater ) ()
- TCPDF 5.9.074 (or grater ) (http://sourceforge.net/project/tcpdf)

INSTALLATION
------------

1. Place the pdfra in web access path (Eg: /var/www/pdfra, /srv/htdocs/pdfra )
2. Set write permission for web server user to pdfra directory
3. cd to js/dojo-custom-build and execute build.sh this will download the dojo source and build for the project.
4. Start MySQL/MariaDB server, Apache server and open pdfra directory from web browser.
5. Read the License 
6. Provide the mysql host (Eg: localhost) root password, name for the pdfra database, and a password for the pdfra database.
7. If there are any errors fix it an redo the database creation process.
8. Now your done.. reload the web browser and you will be presented with the default pdfra modules. 


CREATING THE FIRST MODULE
-------------------------
Four modules will be available by default the system module is to manage the pdfra system
1. system
2. doc  
3. home  
4. sample  

* Modules are placed in =mod= directory
* The modules added to =modules.php= will only be available to the front-end

1. To create your first module copy =sample= module to a new name (Eg: firstMod)
2. Now change =modules.php= and add following entry to the php array.

"firstMod"   =>array('MODULE'=>"First Module",'VISIBLE'=>'true'),



