# Silkroad Express API

This project of API for Silkroad express company. <a href="https://laravel.com/docs/8.x" target="_blank">Framework Laravel 8x</a>
<br />
If you want to be notified for deployment, just join to our telegram group: <a href="https://t.me/joinchat/F0SDFliVxiagsLZpmakOBA" target="_blank">Silkroad Telegram Group</a>
 
## Technical requirements
1. PHP 7.3
2. MySQL 5.6 / Recommended version 8x
3. Composer last version
4. GIT last version

## Installation guide
```git clone https://github.com/Silkroad-Express/sr-api.git``` <br>
```cd sr-api``` <br>
```composer install``` <br>
```cp .env.example .env``` <br>
```nano .env``` and set up your DB connections, APP_ENV = local || prod (prod - for production mode) and ```CTRL+X``` <br>
```php artisan key:generate``` <br>
```php artisan migrate``` <br>
```php artisan db:seed``` <br>
 
 ---
 
# 🐳 With Docker

## Clone project
```
git clone https://github.com/Silkroad-Express/silkroad-api.git
```
### Building docker image
```
cd silkroad-api
```
```
docker build -t silkroad-api .
```
### Set environment variables
Just create .env file the same as .env.example with appropriate values
```
cp .env.example .env
```
> Importan: If you have any artisan generated key you can set it manually to .env file.
Or you can simply run <br /> `` php artisan key:generate ``

### Run docker container
Make sure that 8080 port is not used.
```
docker run -d -p 8080:80 --env-file .env silkroad-api
```
Happy coding... ☕️
