{foreach $vhosts_array as $host}
<VirtualHost *:80>
    <Directory "{$host->getVhostDir()}">
               Options Indexes FollowSymLinks Includes ExecCGI
               AllowOverride All
               Order allow,deny
               Allow from all
    </Directory>
   DocumentRoot "{$host->getVhostHtdocs()}"
   ServerName {$host->getFullDomain()}
</VirtualHost>
{/foreach}