# Installhelper

This script will help you to run curserver - Tool by Jörg Wrase (cusp.de)

Please make sure that you have the right directory structure

This tool will overwrite some settings (my.ini from mysql, php.ini)
The settings that will be changed are defined in the replacement.ini. 

DIRECTORY STRUCTURE:

+ Every Xampp-Installation must be in its own directory
+ The directory-name must have following structure:

   xampp-[version number][-optional part]
   
   #### Examples that *would work*:  

   + xampp-7.1.25-64Bit
   + xampp-5.4
   + xampp-7-mytext
   + xampp-7.3
   
   #### Examples that *do not work*:
   
   + **_xampp-7.0** /* The prefix must be xampp- without a leading sign
   + **xampp** /* this can work - but no version number is detected. So maybe it will insert the wrong templates
   + **xampp-5-3** /* Here is the Version "5" NOT 5.3 (3 is the optional part, not evaluated by this tool) 
   

+ All xampp-directories must be on the same level (all in one directory)
+ This tool must be in the same directory

    Example:
    
    curserver  
    xampp-5.5  
    xampp-5.6  
    xampp-7.1  
    xampp-7.2  
    xampp-7.5_beta  
        
+ XDEBUG will be switched on

WARNING: USE THIS TOOL ON YOUR OWN RISK. IT CAN BREAK YOUR XAMPP-INSTALLATIONS
I'M NOT RESPONSIBLE FOR ANY PROBLEMS WITH THIS TOOL OR ANY DAMAGES THROUGH THIS TOOL

    We assume that you have installed a php-version which  
    is in your %PATH% - Variable.  
    For me I have one xampp installed on  
    C:\xampp (standard-path). And this xampp has nothing to do  
    with the xampps controlled by this curserver-tool, except we need the php to run some
    console php-files during installation

## Installation:

Check out from git or download it.
Make sure, you have installed composer on your system.



>dir *directoryFrom/curserver/installer/*  
>php install.php

*The first think you should do after finished the installation is to create a domain for this tool*


