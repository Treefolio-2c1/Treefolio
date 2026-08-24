-- ============================================================
-- Treefolio — banco de dados
-- Estrutura original preservada; apenas organizado/comentado.
-- ============================================================

CREATE DATABASE treefolio;
USE treefolio;

-- ------------------------------------------------------------
-- Usuários
-- ------------------------------------------------------------
CREATE TABLE usuario (
    id_user       INT PRIMARY KEY AUTO_INCREMENT,
    nome          VARCHAR(50) NOT NULL,
    email         VARCHAR(50) UNIQUE NOT NULL,
    fone          VARCHAR(20) UNIQUE NOT NULL,
    status        ENUM('ativo', 'inativo') DEFAULT 'ativo',        -- conta ativa/desativada pelo admin
    senha         VARCHAR(500) NOT NULL,
    status_email  ENUM('ativo', 'inativo') DEFAULT 'inativo',      -- e-mail confirmado?
    status_fone   ENUM('ativo', 'inativo') DEFAULT 'inativo',
    token         VARCHAR(64),                                      -- token de confirmação de e-mail
    ocupacao      VARCHAR(100),
    datanasc      DATE,
    foto          VARCHAR(255),
    adm           ENUM('1', '0') DEFAULT '0'
);

-- ------------------------------------------------------------
-- Categorização
-- ------------------------------------------------------------
CREATE TABLE tags (
    id_tag INT PRIMARY KEY AUTO_INCREMENT,
    tag    VARCHAR(35) UNIQUE
);

CREATE TABLE categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    categoria    VARCHAR(35) UNIQUE
);

-- ------------------------------------------------------------
-- Projetos
-- ------------------------------------------------------------
CREATE TABLE projetos (
    id_projeto INT PRIMARY KEY AUTO_INCREMENT,
    id_user    INT NOT NULL,
    titulo     VARCHAR(50) NOT NULL,
    descricao  TEXT,
    categoria  VARCHAR(50),
    capa       VARCHAR(255),
    dataproj   DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_user) REFERENCES usuario(id_user)
);

-- ------------------------------------------------------------
-- Posts
-- ------------------------------------------------------------
CREATE TABLE post (
    id_post      INT PRIMARY KEY AUTO_INCREMENT,
    id_user      INT,
    id_projeto   INT NULL,
    id_categoria INT,
    arquivo      VARCHAR(255),
    capa         VARCHAR(255),
    legenda      TEXT,
    datapost     DATETIME DEFAULT CURRENT_TIMESTAMP,
    feed         BOOLEAN DEFAULT TRUE,
    tipo         VARCHAR(20),

    FOREIGN KEY (id_user) REFERENCES usuario(id_user),
    FOREIGN KEY (id_projeto) REFERENCES projetos(id_projeto),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

-- ------------------------------------------------------------
-- Perfil (dados complementares do usuário)
-- ------------------------------------------------------------
CREATE TABLE perfil (
    id_perfil INT PRIMARY KEY AUTO_INCREMENT,
    id_user   INT UNIQUE,
    bio       TEXT,

    FOREIGN KEY (id_user) REFERENCES usuario(id_user)
);

-- ------------------------------------------------------------
-- Avaliações
-- ------------------------------------------------------------
CREATE TABLE review (
    id_review  INT PRIMARY KEY AUTO_INCREMENT,
    id_user    INT,
    id_avaliado INT,
    review     TEXT,
    nota       DECIMAL(2,1) CHECK (nota >= 0 AND nota <= 5),

    FOREIGN KEY (id_user) REFERENCES usuario(id_user),
    FOREIGN KEY (id_avaliado) REFERENCES usuario(id_user)
);

-- ------------------------------------------------------------
-- Curtidas
-- ------------------------------------------------------------
CREATE TABLE likes (
    id_like    INT PRIMARY KEY AUTO_INCREMENT,
    id_user    INT,
    id_post    INT NULL,
    id_projeto INT NULL,

    FOREIGN KEY (id_user) REFERENCES usuario(id_user),
    FOREIGN KEY (id_post) REFERENCES post(id_post),
    FOREIGN KEY (id_projeto) REFERENCES projetos(id_projeto)
);

-- ------------------------------------------------------------
-- Seguidores
-- ------------------------------------------------------------
CREATE TABLE seguidores (
    id_seguidor INT,
    id_seguido  INT,

    PRIMARY KEY (id_seguidor, id_seguido),

    FOREIGN KEY (id_seguidor) REFERENCES usuario(id_user),
    FOREIGN KEY (id_seguido) REFERENCES usuario(id_user)
);

-- ------------------------------------------------------------
-- Comentários
-- ------------------------------------------------------------
CREATE TABLE comentarios (
    id_comentario   INT PRIMARY KEY AUTO_INCREMENT,
    id_post         INT NOT NULL,
    id_user         INT NOT NULL,
    comentario      TEXT NOT NULL,
    datacomentario  DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_post) REFERENCES post(id_post),
    FOREIGN KEY (id_user) REFERENCES usuario(id_user)
);

-- ------------------------------------------------------------
-- Visualizações
-- ------------------------------------------------------------
CREATE TABLE visualizacoes (
    id_visualizacao   INT PRIMARY KEY AUTO_INCREMENT,
    id_user           INT NOT NULL,
    id_post           INT NULL,
    id_projeto        INT NULL,
    datavisualizacao  DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_user) REFERENCES usuario(id_user),
    FOREIGN KEY (id_post) REFERENCES post(id_post),
    FOREIGN KEY (id_projeto) REFERENCES projetos(id_projeto)
);

-- ------------------------------------------------------------
-- Relação Post <-> Tags
-- ------------------------------------------------------------
CREATE TABLE post_tags (
    id_post INT,
    id_tag  INT,

    PRIMARY KEY (id_post, id_tag),

    FOREIGN KEY (id_post) REFERENCES post(id_post),
    FOREIGN KEY (id_tag) REFERENCES tags(id_tag)
);

-- ------------------------------------------------------------
-- Currículo
-- ------------------------------------------------------------
CREATE TABLE curriculo (
    id_curriculo  INT PRIMARY KEY AUTO_INCREMENT,
    id_user       INT UNIQUE NOT NULL,
    formacao      TEXT,
    experiencia   TEXT,
    habilidades   TEXT,
    cursos        TEXT,
    idiomas       TEXT,

    FOREIGN KEY (id_user) REFERENCES usuario(id_user)
);
