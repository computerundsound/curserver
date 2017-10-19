{foreach $vhosts_array as $host}
<VirtualHost *:{$port}>
	<Directory "{$host->getVhostDir()}">
		Options Indexes FollowSymLinks Includes ExecCGI
		AllowOverride All
		Require all granted
	</Directory>

	DocumentRoot "{$host->getVhostHtdocs()}"
	ServerName {$host->getFullDomain()}
</VirtualHost>
{/foreach}