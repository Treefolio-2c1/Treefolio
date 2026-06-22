create database treefolio;
use treefolio;

create table usuario (
id_user int primary key auto_increment,
nome varchar(50),
email varchar(50) unique,
fone  varchar(20) unique,
status enum('ativo', 'inativo') default 'ativo',
foto varchar(255),
senha varchar(500)
);

create table projetos (
id_projeto int primary key auto_increment,
id_user int,
titulo varchar(50) not null,
descricao text,
dataproj datetime default current_timestamp,

foreign key (id_user) references usuario(id_user)
);

create table post (
id_post int primary key auto_increment,
id_user int,
id_projeto int null,
file varchar(255),
legenda text,
datapost datetime default current_timestamp,
likes int default 0,
feed boolean default true,

foreign key(id_user) references usuario(id_user),
foreign key (id_projeto) references projetos(id_projeto)
);

alter table usuario
add bio text;

select * from usuario;



