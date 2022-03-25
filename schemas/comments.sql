create table if not exists comments(
    id int not null auto_increment primary key,
    user int not null foreign key users(id),   --Ve los usuarios
    date datetime not null,
    reference int not null foreign key publications(id),
    body text

);