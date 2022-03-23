create table if not exists publicacion(
    id int not null auto_increment primary key, 
    anonymous varchar(100) not null,
    only_read varchar(20 ) not null,  --Modo lectura
    total_ans varchar(255) not null,  --Total de usuarios sin registro en modo lectura

);
