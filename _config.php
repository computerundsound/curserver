<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 30.06.2014
 * Time: 02:26
 *
 * Created by IntelliJ IDEA
 *
 * Filename: _config.php
 */

// copy this file to _config.php

define('CU_DEBUG_MODUS', false); // false | true

/* mysql */

define('DB_SERVER', 'localhost'); // Database ServerName.  # Normal: localhost
define('DB_NAME', 'curserver'); // DatabaseName - Insert your own value please
define('DB_USER', 'curserver'); // Database UserName - Insert your own value please
define('DB_PW', 'curserver'); // Database Password - Insert your own value please

/* If you want to make a backup from all Databases, curServer needs root credentials: */

define('DB_USER_ROOT', 'root'); // Database UserName from Database-Root-User - Insert your own value please
define('DB_PW_ROOT', ''); // Database Password from Database-Root-User - Insert your own value please

define('PATH_TO_VHOSTS', dirname(__DIR__) . '/');

/* Pfade */

// Path for the Windows host-File. Normal it's "c:\Windows\System32\drivers\etc\hosts"
define('HOST_FILE_PATH', 'c:\Windows\System32\drivers\etc\hosts');

define('VHOST_FILES',
       serialize([
                     'VHOST_FILE_IF_VERSION_IS_GREATER_OR_EQUAL_THAN_5_4'       => [
                         'templateName' => 'vhosts.tpl',
                         'fileName'     => 'cu_vhost.txt',
                     ],
                     'VHOST_FILE_IF_VERSION_IS_GREATER_THAN_5_SMALLER_THEN_5_4' => [
                         'templateName' => 'vhosts_5_3.tpl',
                         'fileName'     => 'cu_vhost_5_3.txt',
                     ],
                     'VHOST_FILE_IF_VERSION_IS_SMALLER_THEN_5'                  => [
                         'templateName' => 'vhosts_4.tpl',
                         'fileName'     => 'cu_vhost_4.txt',
                     ],
                 ]

       ));

/*
   This is a Batch-File. It will start an Desktop-Shortcut "%UserProfile%\Desktop\Edit Host.lnk"
   The Edit Host.lnk should exist. I should oben the Windows v-host-File with administrator-Rights.

   So you can easy copy/paste the content of the Windows - Host-File from the curserver-Tool
*/
define('EDITOR_COMMAND_OPEN_HOST_FILE', 'inc\_close\edit_host.bat');

/*
	When you add a new Host, you can choose your own toplevel-Domain (or even let it be blank).
	I use the name of my Computer: cu1 oder cu2.
	This value is the default Value, when you want to add a new vHost.
	You change every added Host with the curserver-Tool (when the host is added by curserver).
 */
define('STANDARD_TLD', 'myc');

/*
 * If you change this port, you have to edit every httpd.conf file for every XAMPP installation.
 * In the httpd.conf-Files you will find the line
 *
 * listen:80
 *
 * You have to change the default 80 value to the Value you change this CU_PORT value here
 */
define('CU_PORT', 80); // Default: 80

/*
 * Here you can define 2 own links witch will be shown in your navbar -
 *
 * Format: url|Linktext
 *
 * Example:
 *
 * define('USERL_LINK_IN_MENUE_1', 'https://cusp.de|My Homepage cusp');
 *
 * will create: <a href="https://cusp.de">My Homepage cusp
 *
 */
define('USERL_LINK_IN_MENUE_1', '');
define('USERL_LINK_IN_MENUE_2', '');