create table forum.user
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

create table forum.topic
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
        foreign key (autor) references forum.user (id)
);

create table forum.comment
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
        foreign key (autor) references forum.user (id),
    constraint topic___fk
        foreign key (topic) references forum.topic (id)
);

create view information_schema.ALL_PLUGINS as
-- missing source code
;

create view information_schema.APPLICABLE_ROLES as
-- missing source code
;

create view information_schema.CHARACTER_SETS as
-- missing source code
;

create view information_schema.CHECK_CONSTRAINTS as
-- missing source code
;

create view information_schema.CLIENT_STATISTICS as
-- missing source code
;

create view information_schema.COLLATIONS as
-- missing source code
;

create view information_schema.COLLATION_CHARACTER_SET_APPLICABILITY as
-- missing source code
;

create view information_schema.COLUMNS as
-- missing source code
;

create view information_schema.COLUMN_PRIVILEGES as
-- missing source code
;

create view information_schema.ENABLED_ROLES as
-- missing source code
;

create view information_schema.ENGINES as
-- missing source code
;

create view information_schema.EVENTS as
-- missing source code
;

create view information_schema.FILES as
-- missing source code
;

create view information_schema.GEOMETRY_COLUMNS as
-- missing source code
;

create view information_schema.GLOBAL_STATUS as
-- missing source code
;

create view information_schema.GLOBAL_VARIABLES as
-- missing source code
;

create view information_schema.INDEX_STATISTICS as
-- missing source code
;

create view information_schema.INNODB_BUFFER_PAGE as
-- missing source code
;

create view information_schema.INNODB_BUFFER_PAGE_LRU as
-- missing source code
;

create view information_schema.INNODB_BUFFER_POOL_STATS as
-- missing source code
;

create view information_schema.INNODB_CMP as
-- missing source code
;

create view information_schema.INNODB_CMPMEM as
-- missing source code
;

create view information_schema.INNODB_CMPMEM_RESET as
-- missing source code
;

create view information_schema.INNODB_CMP_PER_INDEX as
-- missing source code
;

create view information_schema.INNODB_CMP_PER_INDEX_RESET as
-- missing source code
;

create view information_schema.INNODB_CMP_RESET as
-- missing source code
;

create view information_schema.INNODB_FT_BEING_DELETED as
-- missing source code
;

create view information_schema.INNODB_FT_CONFIG as
-- missing source code
;

create view information_schema.INNODB_FT_DEFAULT_STOPWORD as
-- missing source code
;

create view information_schema.INNODB_FT_DELETED as
-- missing source code
;

create view information_schema.INNODB_FT_INDEX_CACHE as
-- missing source code
;

create view information_schema.INNODB_FT_INDEX_TABLE as
-- missing source code
;

create view information_schema.INNODB_LOCKS as
-- missing source code
;

create view information_schema.INNODB_LOCK_WAITS as
-- missing source code
;

create view information_schema.INNODB_METRICS as
-- missing source code
;

create view information_schema.INNODB_MUTEXES as
-- missing source code
;

create view information_schema.INNODB_SYS_COLUMNS as
-- missing source code
;

create view information_schema.INNODB_SYS_DATAFILES as
-- missing source code
;

create view information_schema.INNODB_SYS_FIELDS as
-- missing source code
;

create view information_schema.INNODB_SYS_FOREIGN as
-- missing source code
;

create view information_schema.INNODB_SYS_FOREIGN_COLS as
-- missing source code
;

create view information_schema.INNODB_SYS_INDEXES as
-- missing source code
;

create view information_schema.INNODB_SYS_SEMAPHORE_WAITS as
-- missing source code
;

create view information_schema.INNODB_SYS_TABLES as
-- missing source code
;

create view information_schema.INNODB_SYS_TABLESPACES as
-- missing source code
;

create view information_schema.INNODB_SYS_TABLESTATS as
-- missing source code
;

create view information_schema.INNODB_SYS_VIRTUAL as
-- missing source code
;

create view information_schema.INNODB_TABLESPACES_ENCRYPTION as
-- missing source code
;

create view information_schema.INNODB_TABLESPACES_SCRUBBING as
-- missing source code
;

create view information_schema.INNODB_TRX as
-- missing source code
;

create view information_schema.KEY_CACHES as
-- missing source code
;

create view information_schema.KEY_COLUMN_USAGE as
-- missing source code
;

create view information_schema.OPTIMIZER_TRACE as
-- missing source code
;

create view information_schema.PARAMETERS as
-- missing source code
;

create view information_schema.PARTITIONS as
-- missing source code
;

create view information_schema.PLUGINS as
-- missing source code
;

create view information_schema.PROCESSLIST as
-- missing source code
;

create view information_schema.PROFILING as
-- missing source code
;

create view information_schema.REFERENTIAL_CONSTRAINTS as
-- missing source code
;

create view information_schema.ROUTINES as
-- missing source code
;

create view information_schema.SCHEMATA as
-- missing source code
;

create view information_schema.SCHEMA_PRIVILEGES as
-- missing source code
;

create view information_schema.SESSION_STATUS as
-- missing source code
;

create view information_schema.SESSION_VARIABLES as
-- missing source code
;

create view information_schema.SPATIAL_REF_SYS as
-- missing source code
;

create view information_schema.STATISTICS as
-- missing source code
;

create view information_schema.SYSTEM_VARIABLES as
-- missing source code
;

create view information_schema.TABLES as
-- missing source code
;

create view information_schema.TABLESPACES as
-- missing source code
;

create view information_schema.TABLE_CONSTRAINTS as
-- missing source code
;

create view information_schema.TABLE_PRIVILEGES as
-- missing source code
;

create view information_schema.TABLE_STATISTICS as
-- missing source code
;

create view information_schema.TRIGGERS as
-- missing source code
;

create view information_schema.USER_PRIVILEGES as
-- missing source code
;

create view information_schema.USER_STATISTICS as
-- missing source code
;

create view information_schema.VIEWS as
-- missing source code
;

create view information_schema.user_variables as
-- missing source code
;


