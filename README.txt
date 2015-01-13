
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
- DOJO 1.7.5 (http://download.dojotoolkit.org/)
- TCPDF 5.9.074 (http://sourceforge.net/project/tcpdf)

INSTALLATION
------------

1. Place the pdfra in web access path (Eg: /var/www/pdfra, /srv/htdocs/pdfra )
2. Set write permission for web server user to pdfra directory
3. cd to js/dojo-custom-build and execute build.sh this will download the dojo source and build for the project.
4. Copy modules.php.sample as modules.php, permissions.php.sample as permission.php and config.php.sample as config.php
5. Start MySQL/MariaDB server, Apache server
6. Edit config.php and set W_ROOT to the web path to the pdfra directory (Eg: /pdfra if pdfra is in the web root)
7. Open pdfra directory from web browser Read the License  and close the dialog box
8. Provide the mysql host (Eg: localhost) root password, name for the pdfra database, and a password for the pdfra database.
9. If there are any errors fix it an redo the database creation process.
10. Now your done.. Reload the web browser and login with admin:admin and you will be presented with the default pdfra modules. 


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

3. Edit firstMod/core/database_schema.php and add the tables DDLs to the php array and you can manage the schema version.
4. Edit firstMod/core/database.php and add the table name mappings to be used in the codes.
5. To add a functionality (page) to the module you have to create three php files (Eg: test.php, test_mdl.php, test_viw.php) where 
   - test_mdl.php    -> model
   - test_viw.php    -> view
   - test.php        -> control

   * When you want to create a form to enter data to the table, you just have to create the control file including the table name and the model (_mdl) and view (_viw) will be auto generated in the first access of the functionality so you can customize late as you wish.

5. Edit firstMod/menu.php  and add the functionalities you want to present to the front-end to presetnt test functionality above, you have to add below line to the array in menu.php.

"test"     =>array("label"=>"Testing ","visible"=>"true",'tooltip'=>'tooltip'),

6. To create the related database (given in database_schema.php) for the module you have to go to System > Database Upgrade/Migrate functionality and select the module and check create and press Create/Re-create button.
