use TimeTravel;
insert into roles(name) values ('user');
alter table users modify column rol varchar(30) not null default "user" references roles(name) on update cascade on delete set default;

