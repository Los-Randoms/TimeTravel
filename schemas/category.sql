create table if not exists categories(
    id int not null auto_increment primary key,
    category_pub int not null foreign key publications(id),
    date datetime not null
);
