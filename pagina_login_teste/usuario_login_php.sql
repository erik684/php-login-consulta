USE hospitais;
create table usuario (id_usuario INT AUTO_INCREMENT PRIMARY KEY,
                      usuario VARCHAR(30) NOT NULL,
                      senha VARCHAR(16) NOT NULL);

INSERT INTO usuario (usuario, senha) VALUES ('admin', 'admin')