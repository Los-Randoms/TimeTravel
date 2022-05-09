create database TimeTravel;
use TimeTravel;

create table role(
	id int unsigned not null auto_increment primary key,
	name varchar(30) not null unique
);

create table permission(
	id int unsigned not null auto_increment primary key,
	name varchar(50) not null unique
);

create table access(
	rol int unsigned not null references role(id)
		on delete cascade,
	permission int unsigned not null references permission(id)
		on delete cascade,
);

create table file(
	id int unsigned not null auto_increment primary key,
	filename varchar(255) not null,
	mime varchar(255) not null,
	path varchar(255) not null,
	size int unsigned not null
);

create table user(
	id int unsigned not null auto_increment primary key,
	username varchar(40) not null,
	email varchar(255) not null unique,
	password varchar(60) not null,
	rol varchar(30) default null references role(name)
		on update cascade 
		on delete set null,
	avatar int unsigned references file(id) 
		on delete set null,
	banned boolean not null default false,
	creation datetime not null default current_timestamp
);


insert into role(name) values ('admin');
insert into user set
	username = 'admin',
	email = 'admin@test.xyz',
	password = '$2y$10$.gS76CywJEtagdz8HGzqKeUsLWfmS/RUmhThFqXZlb4kJAkN0cUF6',
	role = 'admin';
