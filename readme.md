# curServer - XAMPP-Manager (DNS) for Windows #

You can manage your XAMPP Virtual-Hosts with this tool.

You can easy add new Hosts, or change them - and of course - delete them.
 
This tool will add the new Hosts into Apache automatically and will help you
very easy to edit your .host - File on Windows (just copy-paste).

You will see all installed vHost from your system in one File - all editable.

See an example on Youtube

I will write the link here soon.


# Installation #

The first local host must be created manually:

I will create a short Video on youtoube that will show you, how to install and manage different 
XAMPP-Versions.

But in short words:

1. Copy all Files into a Directory of your choice.  
2. Install XAMPP(s)
3. Enable vhosts in XAMPP (you can use one vhost.conf - File for multiple XAMPP - Versions if you like - you can see it in the installation - Video)  
The curserver-Tool provides two vhost-Files in the _install_helper Directory. Please update your Paths.
5. Create a Database and import the /_install_helper/cursystem.db.sql - File
6. Create a Desktop - Shortcut with Administrator rights for editing your local Windows host - File (Normal: c:\Windows\System32\drivers\etc\hosts)
7. Add the line **127.0.0.1 curserver** to your Windows host-File
8. Copy the **_config.sample.php to _config.php**
9. Edit the _config.php - File. 

Now don't forget to restart Apache!

Now open the curservertool in your browser [http://curserver/](http://curserver/) and create an virtual host for curserver.

## Why must I create a vhost for the curserver with the curserver-Tool after I have installed the tool?

Because when you create your first vhost, the curserver-Tool will overwrite your vhost-files with the data from the Database.


## Hint

I use notepad++ and have an .ink - File on my Desktop. This file is going to run with administrator-rights, and will open the host-file.

[Computer-Und-Sound](http://www.Computer-Und-Sound.de)
  
    
#