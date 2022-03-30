create table if not exists publications(
    id int not null auto_increment primary key, 
    tittle varchar(255) not null,
    image int not null foreign key files(id),
    date datetime not null,
    user int not null foreign key users(id),
    txt text

);