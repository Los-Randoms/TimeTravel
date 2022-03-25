create table if not exists comments(
    id int not null auto_increment primary key,
    username int not null foreign key users(id),   --Ve los usuarios
);