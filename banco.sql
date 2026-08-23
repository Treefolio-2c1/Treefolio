create database treefolio;
use treefolio;

create table usuario (
    id_user int primary key auto_increment,
    nome varchar(50) not null,
    email varchar(50) unique not null,
    fone  varchar(20) unique not null,
    status enum('ativo', 'inativo') default 'ativo',
    senha varchar(500) not null,
    status_email enum('ativo', 'inativo') default 'inativo',
    status_fone enum('ativo', 'inativo') default 'inativo',
    token varchar(64),
    ocupacao varchar(100),
    datanasc date,
    foto VARCHAR(255),
    adm enum(1, 0) default 0
);

create table tags (
  id_tag int primary key auto_increment,
  tag varchar(35) unique

);

create table categorias (
  id_categoria int primary key auto_increment,
  categoria varchar(35) unique
);

create table projetos (
    id_projeto int primary key auto_increment,
    id_user int NOT NULL,
    titulo varchar(50) not null,
    descricao text,
    categoria varchar(50),
    capa varchar(255),
    dataproj datetime default current_timestamp,

    foreign key (id_user) references usuario(id_user)
);

create table post (
    id_post int primary key auto_increment,
    id_user int,
    id_projeto int null,
    id_categoria int,
    arquivo varchar(255),
    capa varchar(255),
    legenda text,
    datapost datetime default current_timestamp,
    feed boolean default true,
    tipo varchar(20),


    foreign key(id_user) references usuario(id_user),
    foreign key (id_projeto) references projetos(id_projeto),
    foreign key (id_categoria) references categorias(id_categoria)
);

create table perfil (
    id_perfil int primary key  auto_increment,
    id_user int unique,
    bio text,


    foreign key(id_user) references usuario(id_user)
);

create table review (
    id_review int primary key auto_increment,
    id_user int,
    id_avaliado int,
    review text,
    nota decimal(2,1) check (nota >= 0 and nota <=5),

    foreign key(id_user) references usuario(id_user),
    foreign key(id_avaliado) references usuario(id_user)
);



create table likes (
  id_like int primary key auto_increment,
  id_user int,
  id_post int null,
  id_projeto int null,

  foreign key (id_user) references usuario(id_user),
  foreign key (id_post) references post(id_post),
  foreign key (id_projeto) references projetos(id_projeto)

);

create table seguidores (

    id_seguidor int,
    id_seguido int,

    primary key(id_seguidor, id_seguido),

    foreign key(id_seguidor) references usuario(id_user),
    foreign key (id_seguido) references usuario(id_user)

);

create table comentarios (

    id_comentario int primary key auto_increment,

    id_post int not null,
    id_user int not null,

    comentario text not null,

    datacomentario datetime default current_timestamp,

    foreign key(id_post) references post(id_post),
    foreign key(id_user) references usuario(id_user)

);


create table post_tags (
    id_post int,
    id_tag int,


    primary key (id_post, id_tag),

    foreign key (id_post) references post(id_post),
    foreign key (id_tag) references tags(id_tag)
);

create table curriculo (
    id_curriculo int primary key auto_increment,
    id_user int unique not null,
    formacao text,
    experiencia text,
    habilidades text,
    cursos text,
    idiomas text,

    foreign key (id_user) references usuario(id_user)
);