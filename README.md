## Geometry Jump Community Server
Basically a Geometry Dash Server Emulator

Supported version of Geometry Dash: 2.01

(See [the backwards compatibility section of this article](https://github.com/Cvolton/GMDprivateServer/wiki/Deliberate-differences-from-real-GD) for more information)

Tested version of PHP: 8.2.7


### Setup
1) Prepare your server
sudo apt install php mariadb-server apache2
2) Upload the files on a webserver
	git clone https://github.com/thearcticfox-rus/GeometryJumpCommunityServer.git
	cp -r ./GeometryJumpCommunityServer /var/www/html/gjcsdir
3) Import database.sql into a MariaDB database
	sudo mysql
	CREATE USER 'yourusername'@'localhost' IDENTIFIED BY 'yourpassword';
	CREATE DATABASE databasename;
	GRANT ALL PRIVILEGES ON databasename.* TO 'yourusername'@'localhost';
	exit;
	mysql -u yourusername -p yourpassword databasename < /path/to/your/database.sql
4) Prepare "connection.php" file
	sudo nano /var/www/html/gjcsdir/config/connection.php
	Ajust the settings for your database
5) Edit the links in GeometryDash.exe

### Credits
Original by: Cvoltion

Base for account settings and the private messaging system by someguy28

Using this for XOR encryption - https://github.com/sathoro/php-xor-cipher - (incl/lib/XORCipher.php)

Most of the stuff in generateHash.php has been figured out by pavlukivan and Italian APK Downloader, so credits to them
