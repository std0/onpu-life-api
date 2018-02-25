# ONPU Life API

ONPU Life is an Android app developed to improve the interaction between students and teachers. On this page you can find source code of it's API. Source code of an app itself can be found [here](https://github.com/Visorien/ONPU-Life).

# Installation

ONPU Life API requires [PHP](http://php.net/downloads.php) v7.0+ to run. To install this project you need to do the following steps:
1. Download ONPU Life API to any folder.
2. Go to this folder.
   ```sh
   $ cd {folder}
   ```
3. Install the [Composer](https://getcomposer.org/download/).
4. Install all the dependencies.
   ```sh
   $ php composer.phar install
   ```
5. Install the [MySQL Server](https://dev.mysql.com/downloads/installer/).
6. Create the database and new user.
   ```sh
   $ mysql -u root
   ```
   ```sql
   CREATE DATABASE {database};
   ```
   ```sql
   CREATE USER '{user}'@'localhost' IDENTIFIED BY '{password}';
   GRANT ALL PRIVILEGES ON {database}.* TO '{user}'@'localhost';
   FLUSH PRIVILEGES;
   ```
7. Create the .env file and fill it according to the .env.example file in the project's root directory.
8. Run the migrations.
   ```sh
   $ php artisan migrate
   ```
9. Generate the encryption keys for Laravel Passport.
   ```sh
   $ php artisan passport:keys
   ```
10. Install the [nginx](https://nginx.org/en/download.html) web server.
11. Replace the contents of nginx configuration file (vhost.conf) with the following:
    ```nginx
    server {
        listen 80;
        server_name {domain};
        root /{folder}/public;

        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-XSS-Protection "1; mode=block";
        add_header X-Content-Type-Options "nosniff";
    
        index index.html index.htm index.php;
    
        charset utf-8;
    
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
    
        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }
    
        error_page 404 /index.php;
    
        location ~ \.php$ {
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass unix:/var/run/php/php{version}-fpm.sock;
            fastcgi_index index.php;
            include fastcgi_params;
        }
    
        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
    ```
12. Restart the nginx.
    ```sh
    $ sudo systemctl restart nginx
    ```
13. Now you can visit the <http://{domain}> to check if the project was successfully installed.