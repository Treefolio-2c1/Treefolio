create database treefolio;
use treefolio;

create table usuario (
    id_user int primary key auto_increment,
    nome varchar(50),
    email varchar(50) unique,
    fone  varchar(20) unique,
    status enum('ativo', 'inativo') default 'ativo',
    senha varchar(500),
    status_email enum('ativo', 'inativo') default 'inativo',
    status_fone enum('ativo', 'inativo') default 'inativo',
    token varchar(64),
    ocupação varchar(100),
    datanasc date
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
    id_categoria int,
    file varchar(255),
    legenda text,
    datapost datetime default current_timestamp,
    feed boolean default true,


    foreign key(id_user) references usuario(id_user),
    foreign key (id_projeto) references projetos(id_projeto),
    foreign key (id_categoria) references categorias(id_categoria)
);

create table perfil (
    id_perfil int primary key  auto_increment,
    id_user int,
    bio text,
    foto varchar(255),

    foreign key(id_user) references usuario(id_user)
);

create table review (
    id_review int primary key auto_increment,
    id_user int,
    id_perfil int,
    review text,
    nota decimal(1,1),

    foreign key(id_user) references usuario(id_user),
    foreign key(id_perfil) references perfil(id_perfil)
);

create table tags (
  id_tag int primary key auto_increment,
  tag varchar(35)
);

create table categorias (
  id_categoria int primary key auto_increment,
  categoria varchar(35)
);




