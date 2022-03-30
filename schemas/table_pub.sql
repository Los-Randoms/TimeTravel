create table if not exists publications(
    id int not null auto_increment primary key, 
    image int not null foreign key files(id),
    date datetime not null,
    user int not null foreign key users(id),
    txt text

);