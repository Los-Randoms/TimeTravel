#dirP
A minimal framework for PHP>=7.4

## Installation
1. Clone this repo in a custom folder and restart git
```
git clone https://github.com/renk-0/MinPHP.git my_project
cd my_project
rm -rf .git
git init
```
1. Copy and edit .examples/site.conf, change the variable site_dir to the current project directory
```
cp .examples/apache2.conf /etc/apache2/sites-available/site.conf
sed -i '2d;3i\
\tDefine site_dir'$(pwd) site.conf
```
1. Enable the site and start apache2 and mariadb or mysql
```
sudo a2ensite site.conf
sudo systemctl restart apache2 mariadb
```
1. Create a .local.env file and set your enviroment variables
```
touch .local.env
vi .local.env
```
Database conf:
```
[mysql]
username=example
password=example_passwd
port=3365
host=example.com
```
