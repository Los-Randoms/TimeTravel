drop database if exists `Travel-Time`;
create database `Travel-Time`;
use `Travel-Time`;

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


insert into roles(name) values ('admin'), ('user'), ('editor'), ('moderator');
insert into users set
	username = 'admin',
	email = 'admin@test.xyz',
	password = '$2y$10$KtGDLcebrR5bv/BoeNHSc.K/gOhFrxZhHKos9c9cXkqFe5.rSdeG2',
	rol = 'admin';

create table publications(
	id int unsigned not null auto_increment primary key,
	published boolean not null default true,
	title varchar(50) not null,
	body text not null,
	image int unsigned references files(id)
		on delete set null,
	date datetime not null default current_timestamp,
	autor int unsigned not null references users(id)
		on delete cascade
);

create table likes(
	user int unsigned not null references users(id)
		on delete cascade,
	publication int unsigned not null references publications(id)
		on delete cascade
);

create table comments(
	id int unsigned not null auto_increment primary key,
	user int unsigned not null references users(id)
		on delete cascade,
	publication int unsigned not null references publications(id)
		on delete cascade,
	date datetime not null default current_timestamp,
	body text not null
);
