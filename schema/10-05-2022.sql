use TimeTravel;
alter table role rename to roles;
alter table file rename to files;

alter table user rename to users;

alter table publication rename to publications;
-- alter table publication modify column image int unsigned references file(id) on delete set null;
-- alter table publication modify column autor int unsigned not null references user(id) on delete cascade;

alter table `like` rename to likes;
-- alter table `like` modify column user int unsigned not null references user(id) on delete cascade;
-- alter table `like` modify column publication int unsigned not null references publication(id) on delete cascade;

alter table comment rename to comments;
-- alter table comment modify column user int unsigned not null references user(id) on delete cascade;
-- alter table comment modify column publication int unsigned not null references publication(id) on delete cascade;
