PRAGMA FOREIGN_KEYS=ON;

DROP TABLE IF EXISTS Pessoa; 
DROP TABLE IF EXISTS Animal;
DROP TABLE IF EXISTS Adocao;
DROP TABLE IF EXISTS Pedido;
DROP TABLE IF EXISTS Questao;

create table Pessoa     (id INTEGER PRIMARY KEY,
                        username VARCHAR UNIQUE,
                        password VARCHAR NOT NULL,
                        nome TEXT,
                        idade INTEGER CHECK(idade>=18),
                        biografia TEXT,
                        localizacao TEXT,
                        imagem TEXT,
                        favoritos TEXT, --ids dos animais separados por virgulas
                        abrigo TEXT); --string que indica o abrigo a que um utilizador esta associado, string vazia no caso de nao estar associado a nenhum

create table Animal     (id INTEGER PRIMARY KEY, 
                        nome TEXT, 
                        especie TEXT, 
                        raca TEXT,
                        cor TEXT,
                        descricao TEXT,
                        imagem TEXT,
                        estado TEXT); --adotado/em_espera

create table Adocao     (id INTEGER PRIMARY KEY,
                        pessoa INTEGER REFERENCES Pessoa ON UPDATE CASCADE ON DELETE SET NULL,
                        animal INTEGER REFERENCES Animal ON UPDATE CASCADE ON DELETE SET NULL);

create table Pedido     (id INTEGER PRIMARY KEY,
                        pessoa_interessada INTEGER REFERENCES Pessoa ON UPDATE CASCADE ON DELETE SET NULL,
                        info_adocao INTEGER REFERENCES Adocao(id) ON UPDATE CASCADE ON DELETE SET NULL,
                        estado TEXT, --em_espera/aceite/rejeitado
                        CONSTRAINT Unique_Request UNIQUE (pessoa_interessada, info_adocao));


create table Questao    (id INTEGER PRIMARY KEY,
                        animal INTEGER REFERENCES Animal ON UPDATE CASCADE ON DELETE SET NULL,
                        texto TEXT,
                        resposta TEXT);

INSERT INTO Pessoa (id, username, password, nome, idade, biografia, localizacao, imagem, favoritos, abrigo) VALUES (1, 'joaomatos', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'João Matos', 21, 'FEUP Student, Nintendo fan', 'Porto, Portugal', 'default_profile_image.png', "", "MIDAS");
INSERT INTO Pessoa (id, username, password, nome, idade, biografia, localizacao, imagem, favoritos, abrigo) VALUES (2, 'joaopires', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'João Pires', 20, 'FEUP Student, Water Polo Player', 'Porto, Portugal', 'default_profile_image.png', "", "");
INSERT INTO Pessoa (id, username, password, nome, idade, biografia, localizacao, imagem, favoritos, abrigo) VALUES (3, 'tomas', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Tomás Gonçalves', 20, 'FEUP Student, FCPorto supporter', 'Porto, Portugal', 'default_profile_image.png', "", "SOS Animal");
INSERT INTO Pessoa (id, username, password, nome, idade, biografia, localizacao, imagem, favoritos, abrigo) VALUES (4, 'zezao', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Zé Maçães', 20, 'FEUP Student, Salvador Martinha follower', 'Porto, Portugal', 'default_profile_image.png', "", "");

INSERT INTO Animal (id, nome, especie, raca, cor, descricao, imagem, estado) VALUES (1, 'Mantorras', 'Dog', 'Chihuahua', 'Beige', 'Be careful not to step on it.', 'chihuahua.jpg','em_espera');
INSERT INTO Animal (id, nome, especie, raca, cor, descricao, imagem, estado) VALUES (2, 'Usain Bolt', 'Dog', 'Pitbull', 'White', 'Run faster than the real bolt!', 'pitbull.jpg','em_espera');
INSERT INTO Animal (id, nome, especie, raca, cor, descricao, imagem, estado) VALUES (3, 'Lion, the Cereal', 'Cat', 'Sphynx', 'The Ugly Color', 'It does not bark, but it scares.', 'lion.jpg','em_espera');
INSERT INTO Animal (id, nome, especie, raca, cor, descricao, imagem, estado) VALUES (4, 'Miss Piggy', 'Pig', 'Berkshire', 'Pinky', 'Sweet "little" piggy.', 'berkshire.jpg','em_espera');
INSERT INTO Animal (id, nome, especie, raca, cor, descricao, imagem, estado) VALUES (5, 'Toy', 'Canary', 'Harzer Roller', 'Yellow', 'Better when silent.', 'canary.jpg','em_espera');
INSERT INTO Animal (id, nome, especie, raca, cor, descricao, imagem, estado) VALUES (6, 'Like the Car', 'Jaguar', 'Panther', 'Golden', 'With slightly less horses than the car. And cheaper.', 'jaguar.jpg','em_espera');
INSERT INTO Animal (id, nome, especie, raca, cor, descricao, imagem, estado) VALUES (7, 'Voldmort', 'Snake', 'Python', 'Golden', 'Dont look it right in the eyes.', 'snake.jpg','em_espera');

INSERT INTO Adocao (id, pessoa, animal) VALUES (1, 1, 1);
INSERT INTO Adocao (id, pessoa, animal) VALUES (2, 2, 3);
INSERT INTO Adocao (id, pessoa, animal) VALUES (3, 3, 2);
INSERT INTO Adocao (id, pessoa, animal) VALUES (4, 4, 4);
INSERT INTO Adocao (id, pessoa, animal) VALUES (5, 2, 5);
INSERT INTO Adocao (id, pessoa, animal) VALUES (6, 3, 6);
INSERT INTO Adocao (id, pessoa, animal) VALUES (7, 4, 7);

INSERT INTO Pedido (id, pessoa_interessada, info_adocao, estado) VALUES (1, 1, 2, "em_espera");

INSERT INTO Questao (animal, texto, resposta) VALUES (3, "Are the vaccines up to date?", "Yes, they are.");

CREATE TRIGGER IF NOT EXISTS request_state_rejected
AFTER UPDATE
ON Pedido
WHEN NEW.estado = 'rejeitado'
BEGIN
    DELETE FROM Pedido WHERE id = NEW.id;
END;

CREATE TRIGGER IF NOT EXISTS request_state_accepted
AFTER UPDATE
ON Pedido
WHEN NEW.estado = 'aceite'
BEGIN
    DELETE FROM Pedido WHERE info_adocao = NEW.info_adocao;
    DELETE FROM Questao WHERE animal = (SELECT Animal.id as id from Animal, Adocao WHERE Animal.id = Adocao.animal and Adocao.id = NEW.info_adocao);
    DELETE FROM Animal WHERE id = (SELECT Animal.id as id from Animal, Adocao WHERE Animal.id = Adocao.animal and Adocao.id = NEW.info_adocao);
    DELETE FROM Adocao WHERE id = NEW.info_adocao;
END;
