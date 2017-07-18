# Тестовое задание в WebLabs

[Задание](https://docs.google.com/document/d/16ra5k4CYtMD3GNOEHXeOdJI2TwMkKpj8ASWrDLYjVdU/edit)

## Глобальная установка composer

Composer должен быть установлен глобально. Если это не так, выполняем:
```
cd ~
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/bin/composer
```

## Настройка хоста
Хост должен вести в папку `%project%/web`
Примерный конфиг для Apache2:

```
<VirtualHost *:80>
	# The ServerName directive sets the request scheme, hostname and port that
	# the server uses to identify itself. This is used when creating
	# redirection URLs. In the context of virtual hosts, the ServerName
	# specifies what hostname must appear in the request's Host: header to
	# match this virtual host. For the default virtual host (this file) this
	# value is not decisive as it is used as a last resort host regardless.
	# However, you must set it for any further virtual host explicitly.

	ServerName weblabs-task.dev

	ServerAdmin webmaster@localhost
	DocumentRoot /your/server/directory/%project%/web

	<Directory /your/server/directory/%project%/web/>
	# use mod_rewrite for pretty URL support
	RewriteEngine on
	# If a directory or a file exists, use the request directly
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	# Otherwise forward the request to index.php
	RewriteRule . index.php

	AllowOverride All
	Require all granted
</Directory>

	# Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
	# error, crit, alert, emerg.
	# It is also possible to configure the loglevel for particular
	# modules, e.g.
	#LogLevel info ssl:warn

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

	# For most configuration files from conf-available/, which are
	# enabled or disabled at a global level, it is possible to
	# include a line for only one particular virtual host. For example the
	# following line enables the CGI configuration for this host only
	# after it has been globally disabled with "a2disconf".
	#Include conf-available/serve-cgi-bin.conf
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```

## Установка

Склонировать репозиторий:
```
git clone git@github.com:rikosage/weblabs-test.git project
```

Выполнить установку зависимостей

```
composer install
```

Изменить права доступа к папкам:

```
cd /path/to/project
sudo chmod -R 777 runtime
sudo chmod -R 777 web/assets
```

После всех действий проект будет доступен по указанному вами адресу.
