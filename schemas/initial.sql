create table if not exists users(
	id int not null auto_increment primary key,
	username varchar(20) not null,
	email varchar(255) not null,
	password varchar(60) not null,
	role varchar(255)
);

create table if not exists files(
	id int not null auto_increment primary key,
	path varchar(255) not null,
	name varchar(255) not null,
	private boolean not null default TRUE
);

insert into users set 
	username='admin', 
	password='$2y$10$ZjM7/.htHvXXBkkhYdLIYOjhVHuecKXNuGYagr1klath2oTs5mh/y',
	email='admin@admin.com',
	role='admin';

	

	--Comentarios, publicaciones, 	


