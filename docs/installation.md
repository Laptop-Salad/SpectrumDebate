# How to install the project

## Prerequisistes
1. A PHP server such as [Xampp](https://www.apachefriends.org/).
2. [Node.js](https://nodejs.org/en)
3. [Composer](https://getcomposer.org/download/)

## Installation
1. Clone this repository
3. Navigate to the root of the project
2. Install node dependencies
```
npm install
```
3. Install composer dependencies
```
composer install
```
4. Import the database using the file in /database. For example, using PhpMyAdmin.
5. In the /config folder rename [config_template.php](../config/config_template.php) to config.php.
6. Place your username and password for the database in their locations.
7. The project should now be working.