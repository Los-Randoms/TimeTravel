create table if not exists visitors(
    id int not null auto_increment primary key, 
    cant_people int not null,
    ref_pub int not null foreign key publications(id)
    
);
