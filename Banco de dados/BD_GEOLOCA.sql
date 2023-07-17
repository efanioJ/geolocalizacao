DROP DATABASE IF EXISTS geolocalizacao;
CREATE DATABASE geolocalizacao DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE geolocalizacao;


CREATE TABLE funcionario (
nome VARCHAR (100) NOT NULL,
cpf VARCHAR (20) PRIMARY KEY,
email VARCHAR (100) NOT NULL,
senha VARCHAR (50) NOT NULL
);

INSERT INTO funcionario ( nome , cpf , email, senha ) VALUES
('root', '03975204508', 'root@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
('Daniel Correia', '03975204608', 'daniel@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

CREATE TABLE locais (
idLocal int(11) PRIMARY KEY AUTO_INCREMENT,
nomeLocal VARCHAR (100) NOT NULL,
latitude VARCHAR (100),
longitude VARCHAR (100)
);



