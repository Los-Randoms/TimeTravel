use TimeTravel;

insert into role(name) values
	('editor'),
	('moderator');

create table if not exists publication(
	id int unsigned not null auto_increment primary key,
	published boolean not null default true,
	title varchar(50) not null,
	body text not null,
	image int unsigned references file(id),
	date datetime not null default current_timestamp,
	autor int unsigned not null references user(id)
);

create table if not exists `like`(
	user int unsigned not null references user(id),
	publication int unsigned not null references publication(id)
);

create table if not exists `comment`(
	id int unsigned not null auto_increment primary key,
	user int unsigned not null references user(id),
	publication int unsigned not null references publication(id),
	date datetime not null default current_timestamp,
	body text not null
);
