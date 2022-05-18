create database TimeTravel;
use TimeTravel;

create table roles(
	id int unsigned not null auto_increment primary key,
	name varchar(30) not null unique
);

create table files(
	id int unsigned not null auto_increment primary key,
	filename varchar(255) not null,
	mime varchar(255) not null,
	path varchar(255) not null,
	size int unsigned not null
);

create table users(
	id int unsigned not null auto_increment primary key,
	username varchar(40) not null,
	email varchar(255) not null unique,
	password varchar(60) not null,
	rol varchar(30) not null default 'user' references roles(name)
		on update cascade 
		on delete set default,
	avatar int unsigned references files(id) 
		on delete set null,
	banned boolean not null default false,
	creation datetime not null default current_timestamp
);


insert into roles(name) values ('admin'), ('user');
insert into users set
	username = 'admin',
	email = 'admin@test.xyz',
	password = '$2y$10$ropvn0auBvhxos460xrm5OC8hC9cdhSUePL6fokUCStlz1DNakjZm',
	rol = 'admin';

