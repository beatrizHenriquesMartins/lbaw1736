-- Drops
DROP Table IF EXISTS brandBrandManager CASCADE;
DROP TABLE IF EXISTS review CASCADE;
DROP TABLE IF EXISTS purchaseproduct CASCADE;
DROP TABLE IF EXISTS purchase CASCADE;
DROP TABLE IF EXISTS clientaddress CASCADE;
DROP TABLE IF EXISTS country CASCADE;
DROP TABLE IF EXISTS city CASCADE;
DROP TABLE IF EXISTS address CASCADE;
DROP TABLE IF EXISTS cart CASCADE;
DROP TABLE IF EXISTS wishlists CASCADE;
DROP TABLE IF EXISTS product CASCADE;
DROP TABLE IF EXISTS category CASCADE;
DROP TABLE IF EXISTS ban CASCADE;
DROP TABLE IF EXISTS admin CASCADE;
DROP TABLE IF EXISTS brandManager CASCADE;
DROP TABLE IF EXISTS brand CASCADE;
DROP TABLE IF EXISTS message CASCADE;
DROP TABLE IF EXISTS client CASCADE;
DROP TABLE IF EXISTS chatSupport CASCADE;
DROP TABLE IF EXISTS users CASCADE;

DROP FUNCTION IF EXISTS ban_admin() CASCADE;
DROP TRIGGER IF EXISTS ban_admin ON ban CASCADE;
DROP FUNCTION IF EXISTS purchase_cost() CASCADE;
DROP TRIGGER IF EXISTS purchase_cost ON purchase CASCADE;

-- Tables

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  firstName TEXT NOT NULL,
  lastName TEXT NOT NULL,
  username TEXT NOT NULL UNIQUE,
  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  imageURL TEXT NOT NULL,
  dateCreated TIMESTAMP DEFAULT now() NOT NULL,
  dateModified TIMESTAMP DEFAULT now() NOT NULL,
  active BOOLEAN NOT NULL,
  remember_token TEXT
);

CREATE TABLE chatSupport (
  id_chatSupport INTEGER PRIMARY KEY REFERENCES users
);

CREATE TABLE client (
  id_client INTEGER PRIMARY KEY REFERENCES users,
  cellphone INTEGER
);

CREATE TABLE message (
  id SERIAL PRIMARY KEY,
  message TEXT NOT NULL,
  dateSent TIMESTAMP DEFAULT now() NOT NULL,
  sender TEXT NOT NULL CHECK((sender = ANY (ARRAY['Client'::text, 'ChatSupport'::text]))),
  id_chatSupport INTEGER NOT NULL REFERENCES chatSupport,
  id_client INTEGER NOT NULL REFERENCES client
);

CREATE TABLE brand (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL UNIQUE,
  contact INTEGER NOT NULL
);

CREATE TABLE brandManager (
  id_brandManager INTEGER PRIMARY KEY REFERENCES users
);

CREATE TABLE admin (
  id INTEGER PRIMARY KEY REFERENCES brandManager
);

CREATE TABLE ban (
  id_user INTEGER PRIMARY KEY REFERENCES users,
  id_admin INTEGER REFERENCES admin NOT NULL,
  banDate TIMESTAMP DEFAULT now() NOT NULL
);

CREATE TABLE category (
  id SERIAL PRIMARY KEY,
  categoryName TEXT NOT NULL UNIQUE
);

CREATE TABLE product (
  id SERIAL PRIMARY KEY,
  name TEXT UNIQUE NOT NULL,
  quantityInStock INTEGER NOT NULL DEFAULT 0,
  dateCreated TIMESTAMP DEFAULT now() NOT NULL,
  modelNumber INTEGER NOT NULL,
  weight DECIMAL NOT NULL,
  price MONEY NOT NULL,
  imageURL TEXT NOT NULL UNIQUE,
  bigDescription TEXT NOT NULL,
  shortDescription TEXT NOT NULL,
  id_brand INTEGER NOT NULL REFERENCES brand,
  id_category INTEGER NOT NULL REFERENCES category
);

CREATE TABLE wishlists (
  id_product INTEGER REFERENCES product,
  id_client INTEGER REFERENCES client,
  PRIMARY KEY(id_product, id_client)
);

CREATE TABLE cart (
  id_client INTEGER REFERENCES client,
  id_product INTEGER REFERENCES product,
  quantity INTEGER NOT NULL CHECK (quantity > 0),
  PRIMARY KEY(id_client, id_product)
);

CREATE TABLE country (
  id SERIAL PRIMARY KEY,
  country TEXT NOT NULL UNIQUE
);

CREATE TABLE city (
  id SERIAL PRIMARY KEY,
  city TEXT NOT NULL,
  id_country INTEGER NOT NULL REFERENCES country
);

CREATE TABLE address (
  id SERIAL PRIMARY KEY,
  address TEXT NOT NULL,
  zipcode TEXT NOT NULL,
  id_city INTEGER NOT NULL REFERENCES city
);

CREATE TABLE clientaddress (
  id_client INTEGER NOT NULL REFERENCES client,
  id_address INTEGER NOT NULL REFERENCES address,
  PRIMARY KEY(id_client, id_address)
);

CREATE TABLE purchase (
  id SERIAL PRIMARY KEY,
  id_client INTEGER REFERENCES client NOT NULL,
  id_address INTEGER REFERENCES address NOT NULL,
  purchaseDate TIMESTAMP DEFAULT now() NOT NULL,
  purchaseState TEXT NOT NULL,
  cost MONEY NOT NULL CHECK (cost > CAST ( 0 AS MONEY )),
  paymentType TEXT NOT NULL,
  cardNumber TEXT NOT NULL,
  cardName TEXT NOT NULL,
  cardExpirationDate TIMESTAMP NOT NULL,
  nif INTEGER NOT NULL,
  CHECK (cardExpirationDate > purchaseDate)
);

CREATE TABLE purchaseproduct (
  id_purchase INTEGER REFERENCES purchase,
  id_product INTEGER NOT NULL REFERENCES product,
  quantity INTEGER NOT NULL CHECK (quantity > 0),
  cost MONEY NOT NULL CHECK (cost > CAST ( 0 AS MONEY )),
  PRIMARY KEY(id_purchase, id_product)
);

CREATE TABLE review (
  id_product INTEGER NOT NULL REFERENCES product,
  id_purchase INTEGER NOT NULL REFERENCES purchase,
  reviewDate TIMESTAMP DEFAULT now() NOT NULL,
  textReview TEXT NOT NULL,
  rating INTEGER NOT NULL CHECK (((rating >= 0) AND (rating <= 5))),
  PRIMARY KEY(id_product, id_purchase)
);

CREATE TABLE brandBrandManager (
  idBrand INTEGER NOT NULL REFERENCES brand,
  idBrandManager INTEGER NOT NULL REFERENCES brandManager,
  PRIMARY KEY(idBrand, idBrandManager)
);

 -- Indexes

CREATE INDEX idx_message ON message USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_product ON product USING hash (name); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_purchase ON purchase USING btree (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX search_idx ON category USING GIST (to_tsvector('english', categoryName));

 -- Triggers

 --Trigger that prevents an admin from being banned
CREATE FUNCTION ban_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
	IF EXISTS (SELECT * FROM admin WHERE NEW.id_user = admin.id) THEN
		RAISE EXCEPTION 'An Admin can not be banned';
	END IF;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

--Trigger that actualizes the of a product in a purchase according to its actual value
CREATE TRIGGER ban_admin
	BEFORE INSERT OR UPDATE ON ban
	FOR EACH ROW
		EXECUTE PROCEDURE ban_admin();



CREATE FUNCTION purchase_cost() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE purchaseProduct
	SET cost = (SELECT (SELECT price FROM product WHERE id=NEW.id_product) * NEW.quantity) WHERE purchaseProduct.id_product = NEW.id_product AND purchaseProduct.id_purchase = NEW.id_purchase;
	UPDATE purchase
	SET cost = (SELECT SUM(cost2) FROM (SELECT purchaseProduct.cost AS cost2 FROM purchaseProduct WHERE ( purchaseProduct.id_purchase = NEW.id_purchase) ) AS derived_table) WHERE purchase.id = NEW.id_purchase;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;



CREATE TRIGGER purchase_cost
	AFTER INSERT ON purchaseProduct
	FOR EACH ROW
		EXECUTE PROCEDURE purchase_cost();


INSERT INTO users VALUES (DEFAULT, 'Luis', 'Saraiva', 'admin_luissaraiva', 'a_luissaraiva@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Beatriz', 'Henriques', 'admin_beatriz', 'a_beatriz@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Francisco', 'Andrade', 'admin_francisco', 'a_francisco@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Ricardo', 'Abreu', 'admin_ricardo', 'a_ricardo@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Bernardo', 'Leite', 'sprt_bernardoleite', 'sprt_bernardo@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Antonio', 'Pires', 'sprt_antoniopires', 'sprt_antonio@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Jose', 'Cunha', 'sprt_josecunha', 'sprt_jose@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Tomas', 'Costa', 'bm_tomascosta', 'bm_tomas@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Diogo', 'Silva', 'bm_diogosilva', 'bm_diogo@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Joao', 'Monteiro', 'bm_joaomonteiro', 'bm_joao@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Pedro', 'Goncalves', 'pedrogoncalves', 'pedro@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Mariana', 'Oliveira', 'marianaoliveira', 'mariana@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Francisca', 'Rodrigues', 'francisarodrigues', 'francisca@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Ines', 'Pinto', 'inespinto', 'ines@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Raquel', 'Pereira', 'raquelpereira', 'raquel@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Margarida', 'Santos', 'margaridasantos', 'margarida@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Teresa', 'Brito', 'teresabrito', 'teresa@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Tiago', 'Carvalho', 'tiagocarvalho', 'tiago@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Maria', 'Coelho', 'mariacoelho', 'maria@gmail.com', '1234', '', DEFAULT, DEFAULT, true);
INSERT INTO users VALUES (DEFAULT, 'Ana', 'Ferreira', 'anaferreira', 'ana@gmail.com', '1234', '', DEFAULT, DEFAULT, true);


INSERT INTO chatSupport VALUES (5);
INSERT INTO chatSupport VALUES (6);
INSERT INTO chatSupport VALUES (7);


INSERT INTO client VALUES (11, 923132456);
INSERT INTO client VALUES (12, 929432849);
INSERT INTO client VALUES (13, 921232133);
INSERT INTO client VALUES (14, 912375785);
INSERT INTO client VALUES (15, 918478539);
INSERT INTO client VALUES (16, 919453854);
INSERT INTO client VALUES (17, 919648954);
INSERT INTO client VALUES (18, 914834304);
INSERT INTO client VALUES (19, 923456536);
INSERT INTO client VALUES (20, 924254676);

INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 11);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 5, 11);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 11);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 6, 12);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 12);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 6, 12);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 12);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 7, 15);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 7, 15);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 5, 18);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 18);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 5, 18);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 18);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 20);
INSERT INTO message VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 6, 20);


INSERT INTO brand VALUES (DEFAULT, 'Alameda Turquesa', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Aldeia da Roupa Branca', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Alma de Luce', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Ame Moi', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Ana Leite', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Anita Picnic', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Antiflop', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Aparattus', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Babash Design', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Bateye', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Bluf', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Boca do Lobo', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Bordallo Pinheiro', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Briel', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Cabo d Mar', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Candle In', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Cante', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Castelbel', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Cavalinho', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Chicos', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Claus Porto', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Coloradd', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Deamor', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Decenio', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Design Flops', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Doodles', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Dub Dressed', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Ecola', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Enamorata', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Eureka Shoes', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Fasm', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Fio Rosa', 223143243);
INSERT INTO brand VALUES (DEFAULT, 'Science4You', 223143243);

INSERT INTO brandManager VALUES (1);
INSERT INTO brandManager VALUES (2);
INSERT INTO brandManager VALUES (3);
INSERT INTO brandManager VALUES (4);
INSERT INTO brandManager VALUES (8);
INSERT INTO brandManager VALUES (9);
INSERT INTO brandManager VALUES (10);

INSERT INTO admin VALUES (1);
INSERT INTO admin VALUES (2);
INSERT INTO admin VALUES (3);
INSERT INTO admin VALUES (4);

INSERT INTO ban VALUES (20, 1, DEFAULT);

INSERT INTO category VALUES (DEFAULT, 'Fashion');
INSERT INTO category VALUES (DEFAULT, 'Beauty');
INSERT INTO category VALUES (DEFAULT, 'Technology');
INSERT INTO category VALUES (DEFAULT, 'Food');
INSERT INTO category VALUES (DEFAULT, 'Culture');
INSERT INTO category VALUES (DEFAULT, 'Home');
INSERT INTO category VALUES (DEFAULT, 'Sports');

INSERT INTO product VALUES (DEFAULT, 'Gelato', 10, now(), 1, 3.0, 30.00, './src/images/brands/alameda_turquesa/01-holi-400x400.jpg', '', '', 1, 1);
INSERT INTO product VALUES (DEFAULT, 'Holi', 10, now(), 1, 3.0, 30.00, './src/images/brands/alameda_turquesa/2-alameda-turquesa-gelato-400x400.jpg', '', '', 1, 1);
INSERT INTO product VALUES (DEFAULT, 'Chizela', 10, now(), 1, 3.0, 30.00, './src/images/brands/alameda_turquesa/03-chizela-black-alameda-turquesa.png', '', '', 1, 1);
INSERT INTO product VALUES (DEFAULT, 'Frozen', 10, now(), 1, 3.0, 30.00, './src/images/brands/alameda_turquesa/3-frozen-sneakers-alamedaturquesa-400x400.jpg', '', '', 1, 1);
INSERT INTO product VALUES (DEFAULT, 'Cardosas', 10, now(), 1, 3.0, 300.00, './src/images/brands/alma_de_luce/1.jpg', '', '', 3, 6);
INSERT INTO product VALUES (DEFAULT, 'Aparador Multi-Gavetas', 10, now(), 1, 3.0, 300.00, './src/images/brands/alma_de_luce/3.jpg', '', '', 3, 6);


INSERT INTO wishlists VALUES (1, 11);
INSERT INTO wishlists VALUES (2, 12);
INSERT INTO wishlists VALUES (3, 12);
INSERT INTO wishlists VALUES (4, 14);
INSERT INTO wishlists VALUES (5, 15);
INSERT INTO wishlists VALUES (1, 16);
INSERT INTO wishlists VALUES (4, 16);
INSERT INTO wishlists VALUES (1, 19);
INSERT INTO wishlists VALUES (2, 19);
INSERT INTO wishlists VALUES (4, 19);


INSERT INTO cart VALUES (11, 1, 2);
INSERT INTO cart VALUES (11, 3, 2);
INSERT INTO cart VALUES (11, 2, 2);
INSERT INTO cart VALUES (12, 1, 2);
INSERT INTO cart VALUES (13, 5, 1);
INSERT INTO cart VALUES (13, 2, 2);
INSERT INTO cart VALUES (13, 3, 2);
INSERT INTO cart VALUES (13, 1, 1);
INSERT INTO cart VALUES (14, 2, 1);
INSERT INTO cart VALUES (14, 1, 1);
INSERT INTO cart VALUES (16, 4, 1);
INSERT INTO cart VALUES (16, 2, 2);
INSERT INTO cart VALUES (17, 3, 2);
INSERT INTO cart VALUES (17, 1, 2);
INSERT INTO cart VALUES (18, 4, 1);
INSERT INTO cart VALUES (19, 5, 3);


INSERT INTO country VALUES (DEFAULT, 'Portugal');
INSERT INTO country VALUES (DEFAULT, 'Finland');
INSERT INTO country VALUES (DEFAULT, 'Denmark');
INSERT INTO country VALUES (DEFAULT, 'Canada');
INSERT INTO country VALUES (DEFAULT, 'Brazil');
INSERT INTO country VALUES (DEFAULT, 'Australia');
INSERT INTO country VALUES (DEFAULT, 'Austria');
INSERT INTO country VALUES (DEFAULT, 'Poland');
INSERT INTO country VALUES (DEFAULT, 'Belgium');
INSERT INTO country VALUES (DEFAULT, 'Switzerland');
INSERT INTO country VALUES (DEFAULT, 'Italy');
INSERT INTO country VALUES (DEFAULT, 'Netherlands');
INSERT INTO country VALUES (DEFAULT, 'Germany');
INSERT INTO country VALUES (DEFAULT, 'France');
INSERT INTO country VALUES (DEFAULT, 'Spain');
INSERT INTO country VALUES (DEFAULT, 'United Kingdom');
INSERT INTO country VALUES (DEFAULT, 'USA');
INSERT INTO country VALUES (DEFAULT, 'Greece');
INSERT INTO country VALUES (DEFAULT, 'Norway');
INSERT INTO country VALUES (DEFAULT, 'Mozambique');
INSERT INTO country VALUES (DEFAULT, 'Angola');
INSERT INTO country VALUES (DEFAULT, 'Ireland');
INSERT INTO country VALUES (DEFAULT, 'Hungary');
INSERT INTO country VALUES (DEFAULT, 'Romania');
INSERT INTO country VALUES (DEFAULT, 'Sweden');
INSERT INTO country VALUES (DEFAULT, 'Slovenia');

INSERT INTO city VALUES (DEFAULT, 'Porto', 1);
INSERT INTO city VALUES (DEFAULT, 'Lamego', 1);
INSERT INTO city VALUES (DEFAULT, 'Lisboa', 1);
INSERT INTO city VALUES (DEFAULT, 'Coimbra', 1);
INSERT INTO city VALUES (DEFAULT, 'Faro', 1);
INSERT INTO city VALUES (DEFAULT, 'Bragança', 1);
INSERT INTO city VALUES (DEFAULT, 'Leiria', 1);
INSERT INTO city VALUES (DEFAULT, 'Viana do Castelo', 1);
INSERT INTO city VALUES (DEFAULT, 'Braga', 1);
INSERT INTO city VALUES (DEFAULT, 'Guarda', 1);



INSERT INTO address VALUES (DEFAULT, 'Rua Marco de Canaveses 19', '4100-123', 1);
INSERT INTO address VALUES (DEFAULT, 'Avenida 5 de Outubro 52', '4312-234', 2);
INSERT INTO address VALUES (DEFAULT, 'Rua de Moçambique 138', '4152-164', 4);
INSERT INTO address VALUES (DEFAULT, 'Rua Ferreira Lapa 49', '4291-134', 3);
INSERT INTO address VALUES (DEFAULT, 'Rua General Alberto Delgado 534', '3125-343', 5);
INSERT INTO address VALUES (DEFAULT, 'Rua Professor Egas Moniz 243', '3322-421', 6);
INSERT INTO address VALUES (DEFAULT, 'Rua Manuel Simões Maia 123', '2314-432', 7);
INSERT INTO address VALUES (DEFAULT, 'Rua dos Poveiros 77', '2151-542', 8);
INSERT INTO address VALUES (DEFAULT, 'Rua Damião de Góis 211', '1312-321', 9);
INSERT INTO address VALUES (DEFAULT, 'Rua Serpa Pinto 15', '1532-253', 10);


INSERT INTO purchase VALUES (DEFAULT, 11, 1, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 11, 2, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 12, 3, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 212393204);
INSERT INTO purchase VALUES (DEFAULT, 12, 4, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 12, 5, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 15, 6, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 17, 7, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 17, 8, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 19, 9, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchase VALUES (DEFAULT, 19, 10, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);


INSERT INTO purchaseproduct VALUES (1, 5, 1, 300);
INSERT INTO purchaseproduct VALUES (2, 2, 1, 300);
INSERT INTO purchaseproduct VALUES (2, 3, 1, 300);
INSERT INTO purchaseproduct VALUES (3, 1, 1, 300);
INSERT INTO purchaseproduct VALUES (4, 4, 1, 300);
INSERT INTO purchaseproduct VALUES (5, 1, 1, 300);
INSERT INTO purchaseproduct VALUES (6, 3, 1, 300);
INSERT INTO purchaseproduct VALUES (7, 3, 1, 300);
INSERT INTO purchaseproduct VALUES (8, 2, 1, 300);
INSERT INTO purchaseproduct VALUES (9, 2, 1, 300);
INSERT INTO purchaseproduct VALUES (10, 4, 1, 300);
INSERT INTO purchaseproduct VALUES (3, 3, 1, 300);
INSERT INTO purchaseproduct VALUES (4, 1, 1, 300);
INSERT INTO purchaseproduct VALUES (5, 5, 1, 300);
INSERT INTO purchaseproduct VALUES (6, 1, 1, 300);
INSERT INTO purchaseproduct VALUES (7, 2, 1, 300);
INSERT INTO purchaseproduct VALUES (8, 3, 1, 300);
INSERT INTO purchaseproduct VALUES (9, 4, 1, 300);
INSERT INTO purchaseproduct VALUES (10, 2, 1, 300);

INSERT INTO review VALUES (1, 5, DEFAULT, '', 3);
INSERT INTO review VALUES (2, 2, DEFAULT, '', 5);
INSERT INTO review VALUES (3, 2, DEFAULT, '', 5);
INSERT INTO review VALUES (4, 10, DEFAULT, '', 4);
INSERT INTO review VALUES (2, 8, DEFAULT, '', 2);
INSERT INTO review VALUES (1, 3, DEFAULT, '', 3);
INSERT INTO review VALUES (3, 6, DEFAULT, '', 5);
INSERT INTO review VALUES (5, 1, DEFAULT, '', 4);
INSERT INTO review VALUES (4, 4, DEFAULT, '', 4);

INSERT INTO brandBrandManager VALUES (1, 8);
INSERT INTO brandBrandManager VALUES (2, 9);
INSERT INTO brandBrandManager VALUES (3, 10);
INSERT INTO brandBrandManager VALUES (4, 8);
INSERT INTO brandBrandManager VALUES (5, 9);
INSERT INTO brandBrandManager VALUES (6, 10);
INSERT INTO brandBrandManager VALUES (7, 8);
INSERT INTO brandBrandManager VALUES (8, 9);
INSERT INTO brandBrandManager VALUES (9, 10);
INSERT INTO brandBrandManager VALUES (10, 8);
INSERT INTO brandBrandManager VALUES (11, 9);
INSERT INTO brandBrandManager VALUES (12, 10);
INSERT INTO brandBrandManager VALUES (13, 8);
INSERT INTO brandBrandManager VALUES (14, 9);
INSERT INTO brandBrandManager VALUES (15, 10);
INSERT INTO brandBrandManager VALUES (16, 8);
INSERT INTO brandBrandManager VALUES (17, 9);
INSERT INTO brandBrandManager VALUES (18, 10);
