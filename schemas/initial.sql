create table users(
	id int not null auto_increment primary key,
	username varchar(20) not null,
	email varchar(255) not null,
	password varchar(60) not null,
	role varchar(255)
);


