create table if not exists users(
	id int not null auto_increment primary key,
	username varchar(20) not null,
	email varchar(255) not null,
	password varchar(60) not null,
	role varchar(255)
);

insert into users set 
	username='admin', 
	password='$2y$10$ZjM7/.htHvXXBkkhYdLIYOjhVHuecKXNuGYagr1klath2oTs5mh/y',
	email='admin@admin.com',
	role='admin';


