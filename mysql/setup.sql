-- This entire database can be constructed by running “source setup.sql” from mysql.
CREATE DATABASE `weather_box` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;

USE `weather_box`;

GRANT ALL PRIVILEGES ON weather_box.* TO 'the_user'@'localhost' IDENTIFIED BY 'the_password';

-- Ray: The order dose matter. It loads "file.sql" without errors then "user.sql".
source location.sql;
source user.sql;
