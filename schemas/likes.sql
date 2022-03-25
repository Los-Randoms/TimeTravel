create table if not exists likes(
    id int not null auto_increment primary key,
    user int not null foreign key users(id),
    date datetime not null,
    totallk char(255) not null,  --Total de likes

);

