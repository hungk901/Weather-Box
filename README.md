#WEATHER BOX
###A World Clock & Forecast Widget
v0.0.1

-----
##Introduction

Weather box is an app that allows registered users to have specific digital clocks and forecast information by setting up cities which based on their preference. If user keys in "New York, New York" in one of input field, it will show the local time and recent forecast of New York city.

[Github Repo](https://github.com/hungk901/Weather-Box)

-----

##Installation

###Project Folder Location

* Place the project folder 'weather-box' inside 'Sites' folder, which should be inside your home folder. 

	e.g. ./Sites/weather-box

-
###MySQL Setup

1. **Launch The Terminal.**

	```	
	Spotlight > Terminal
	```

2. **Start MySQL.**

 	```
	$ start mysql
	```
	Note: The Terminal will response several lines of message on the window, and its cursor will hang. This is how The Terminal works. Just keep move on to the next step. 
3. **Close the current The Terminal window and open a new one.**

4. **Navigate to the *mysql* folder of this project.**

	```
	$ cd Sites/weather-box/mysql
	```
	Note: Make sure that you have alreay put the project folder inside Sites or The Terminal will tell you that there is not such file or directory.

5. **Log in to MySQL as root user.**

	```
	$ mysql -u root -p
	```

6. **Provide MySQL the contents of setup.sql**

	```
	mysql> source setup.sql
	```
	
7. **Log out MySQL.**

	```
	mysql> exit
	```
	
8. **Log in to MySQL as root again.**

	```
	$ mysql -u root -p
	```
	
9. **Check if the database is created.**

	```
	mysql> show databases;
	```
	weather_box should be inside the Database table.
	
	Note: After key in show databases, add a semicolon at the end of command.
	
10. **Exit MySQL**

	```
	mysql> exit
	```

-
### File and Folder Permissions

1. **Navigate to the *weather-box* folder.**

	```
	$ cd ~/Sites/weather-box/
	```

2. **Give every file in *weather-box* *755* permission.**

    ```
	$ chmod 755 *
	```

-

###Compiling CSS from Sass
1. **Navigate to *weather-box* folder.**

	```
	$ cd Sites/weather-box/
	```
	Note: Make sure that you have alreay put the project folder inside Sites or The Terminal will tell you that there is not such file or directory.
	
2. **Compile Sass to CSS**

	```
	sass --unix-newlines --sourcemap=none --style compressed --watch sass/style.scss:css/style.css
	```
	
-

Ray Hung 20151221 @NJ