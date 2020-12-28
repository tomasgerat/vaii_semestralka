create table user
(
    id         int auto_increment
        primary key,
    login      varchar(30)  not null,
    password   varchar(255) not null,
    e_mail     varchar(50)  not null,
    first_name varchar(100) null,
    last_name  varchar(100) null,
    constraint user_e_mail_uindex
        unique (e_mail),
    constraint users_login_uindex
        unique (login)
);

create table topic
(
    id       int auto_increment
        primary key,
    title    varchar(100)  not null,
    text     text          not null,
    created  datetime      not null,
    edited   datetime      null,
    views    int default 1 not null,
    category int           not null,
    autor    int           not null,
    constraint autor___fk
        foreign key (autor) references user (id)
);

create table comment
(
    id      int auto_increment
        primary key,
    text    text     not null,
    created datetime not null,
    edited  datetime not null,
    deleted tinyint  null,
    topic   int      not null,
    autor   int      not null,
    constraint autor_c___fk
        foreign key (autor) references user (id),
    constraint topic___fk
        foreign key (topic) references topic (id)
);


