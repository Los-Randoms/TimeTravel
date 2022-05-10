use TimeTravel;

insert into roles(name) values
	('editor'),
	('moderator');

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
