create table if not exists comments(
    id int not null auto_increment primary key,
    username varchar(255) not null,   --Ve los usuarios
    comment varchar(300)   not null,  --Ve el total de comentarios que hacen
    spam    varchar(20) not null,     --Detecta el spam en los comentarios 
);