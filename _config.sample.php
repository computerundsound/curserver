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

define('CU_DEBUGMODUS', false); // false | true

/* mysql */

define('DBSERVER', 'localhost'); // Database ServerName.  # Normal: localhost
define('DBNAME', 'curserver'); // DatabaseName - Insert your own value please
define('DBUSER', 'curserver'); // Database UserName - Insert your own value please
define('DBPW', 'curserver'); // Database Password - Insert your own value please

/* Pfade */

// Path for the Windows host-File. Normal it's "c:\Windows\System32\drivers\etc\hosts"
define('HOSTFILE_PATH', 'c:\Windows\System32\drivers\etc\hosts');

/*
 * The curserver-Tool must write into an Apache - vhost-File. (Example: \apache\conf\extra\httpd-vhosts.conf)
 * I recommend that you create new vHost.conf - File (see video for details) and include this in each http-vhost.conf
 * PHP-5.3 needs an other <DIRECTORY> - Tag-Content.
 * So I have one File for PHP-Version > 5.3 and one for 5.3 (smaler once not tested)
 *
 * So the curserver-Tool will only write into this both vhost-conf-Files (I have named them "cu_vhost.txt and cu_vhost_5_3.txt"
 *
 * Because of the different Structur of the <Directory> - Tag, we need 2 vhost-Files
 * (only if you have one XAMPP with php5_3 ** and ** one XAMPP with a heiger php-Version.
 * Wich struktur you need, you can see in the origin httpd-vhost.conf - File of your XAMPP-Installation.
 *
 * curserver brings to vhost-Template with it.
 *
 * In this array, you can add your vhost Files:
 *
 *  "Path to your vhost-File" => "templateName" => "Name of the template-File, that will be used for this vhost-File
 *
 * If you have only one XAMPP-Installation, and the php-Version is heigher than 5_3,
 * you can delete the second line from the array.
 * And you have to update your Path to the cu_vhost.txt (that must be included by the origin vhost File from the Apache.
 *
 */

define('VHOSTFILES',
       serialize([
	                 'e:\XAMPPS\cu_vhosts.txt'     => ['templateName' => 'vhosts.tpl'],
	                 'e:\XAMPPS\cu_vhosts_5_3.txt' => ['templateName' => 'vhosts_5_3.tpl'],
                 ]

       ));

/*
	This is a Batch-File. It will start an Desktop-Shortcut "%UserProfile%\Desktop\Edit Host.lnk"
	The Edit Host.lnk should exist. I should oben the Windows v-host-File with administrator-Rights.

	So you can easy copy/paste the content of the Windows - Host-File from the curserver-Tool
 */
define('EDITOR_COMMAND_OPEN_HOSTFILE', 'inc\_close\edit_host.bat');

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