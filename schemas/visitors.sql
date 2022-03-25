create table if not exists visitors(
    id int not null auto_increment primary key, 
    anonymous varchar(100) not null, --Tiene que registrar cuántos visitan la página de forma anónima
    pages_limit_read char(20)not null,--Se requiere establecer un limite de paginas que puede leer el visitante

);
