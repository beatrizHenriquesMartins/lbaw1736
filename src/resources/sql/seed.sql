-- Drops
DROP Table IF EXISTS brandBrandManagers CASCADE;
DROP TABLE IF EXISTS reviews CASCADE;
DROP TABLE IF EXISTS purchaseproducts CASCADE;
DROP TABLE IF EXISTS purchases CASCADE;
DROP TABLE IF EXISTS clientaddresses CASCADE;
DROP TABLE IF EXISTS countries CASCADE;
DROP TABLE IF EXISTS cities CASCADE;
DROP TABLE IF EXISTS addresses CASCADE;
DROP TABLE IF EXISTS carts CASCADE;
DROP TABLE IF EXISTS wishlists CASCADE;
DROP TABLE IF EXISTS products CASCADE;
DROP TABLE IF EXISTS categories CASCADE;
DROP TABLE IF EXISTS bans CASCADE;
DROP TABLE IF EXISTS admins CASCADE;
DROP TABLE IF EXISTS brandManagers CASCADE;
DROP TABLE IF EXISTS brands CASCADE;
DROP TABLE IF EXISTS messages CASCADE;
DROP TABLE IF EXISTS clients CASCADE;
DROP TABLE IF EXISTS chatSupports CASCADE;
DROP TABLE IF EXISTS users CASCADE;


DROP FUNCTION IF EXISTS ban_admin() CASCADE;
DROP TRIGGER IF EXISTS ban_admin ON bans CASCADE;
DROP FUNCTION IF EXISTS purchase_cost() CASCADE;
DROP TRIGGER IF EXISTS purchase_cost ON purchases CASCADE;

DROP INDEX IF EXISTS idx_message;
DROP INDEX IF EXISTS idx_product;
DROP INDEX IF EXISTS idx_purchase;
DROP INDEX IF EXISTS search_idx;

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

CREATE TABLE chatSupports (
  id_chatSupport INTEGER PRIMARY KEY REFERENCES users
);

CREATE TABLE clients (
  id_client INTEGER PRIMARY KEY REFERENCES users,
  cellphone BIGINT
);

CREATE TABLE messages (
  id SERIAL PRIMARY KEY,
  message TEXT NOT NULL,
  dateSent TIMESTAMP DEFAULT now() NOT NULL,
  sender TEXT NOT NULL CHECK((sender = ANY (ARRAY['Client'::text, 'ChatSupport'::text]))),
  id_chatSupport INTEGER NOT NULL REFERENCES chatSupports,
  id_client INTEGER NOT NULL REFERENCES clients
);

CREATE TABLE brands (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL UNIQUE,
  contact INTEGER NOT NULL
);

CREATE TABLE brandManagers (
  id_brandManager INTEGER PRIMARY KEY REFERENCES users
);

CREATE TABLE admins (
  id INTEGER PRIMARY KEY REFERENCES brandManagers
);

CREATE TABLE bans (
  id_user INTEGER PRIMARY KEY REFERENCES users,
  id_admin INTEGER REFERENCES admins NOT NULL,
  banDate TIMESTAMP DEFAULT now() NOT NULL
);

CREATE TABLE categories (
  id SERIAL PRIMARY KEY,
  categoryName TEXT NOT NULL UNIQUE
);

CREATE TABLE products (
  id SERIAL PRIMARY KEY,
  name TEXT UNIQUE NOT NULL,
  quantityInStock INTEGER NOT NULL DEFAULT 0,
  dateCreated TIMESTAMP DEFAULT now() NOT NULL,
  modelNumber INTEGER NOT NULL,
  weight DECIMAL NOT NULL,
  price DECIMAL NOT NULL,
  imageURL TEXT NOT NULL UNIQUE,
  bigDescription TEXT NOT NULL,
  shortDescription TEXT NOT NULL,
  id_brand INTEGER NOT NULL REFERENCES brands,
  id_category INTEGER NOT NULL REFERENCES categories
);

CREATE TABLE wishlists (
  id_product INTEGER REFERENCES products,
  id_client INTEGER REFERENCES clients,
  PRIMARY KEY(id_product, id_client)
);

CREATE TABLE carts (
  id_client INTEGER REFERENCES clients,
  id_product INTEGER REFERENCES products,
  quantity INTEGER NOT NULL CHECK (quantity > 0),
  PRIMARY KEY(id_client, id_product)
);

CREATE TABLE countries (
  id SERIAL PRIMARY KEY,
  country TEXT NOT NULL UNIQUE
);

CREATE TABLE cities (
  id SERIAL PRIMARY KEY,
  city TEXT NOT NULL,
  id_country INTEGER NOT NULL REFERENCES countries
);

CREATE TABLE addresses (
  id SERIAL PRIMARY KEY,
  address TEXT NOT NULL,
  zipcode TEXT NOT NULL,
  id_city INTEGER NOT NULL REFERENCES cities
);

CREATE TABLE clientaddresses (
  id_client INTEGER NOT NULL REFERENCES clients,
  id_address INTEGER NOT NULL REFERENCES addresses,
  PRIMARY KEY(id_client, id_address)
);

CREATE TABLE purchases (
  id SERIAL PRIMARY KEY,
  id_client INTEGER REFERENCES clients NOT NULL,
  id_address INTEGER REFERENCES addresses NOT NULL,
  purchaseDate TIMESTAMP DEFAULT now() NOT NULL,
  purchaseState TEXT NOT NULL,
  cost DECIMAL NOT NULL CHECK (cost > CAST ( 0 AS DECIMAL )),
  paymentType TEXT NOT NULL,
  cardNumber TEXT NOT NULL,
  cardName TEXT NOT NULL,
  cardExpirationDate TIMESTAMP NOT NULL,
  nif INTEGER NOT NULL,
  CHECK (cardExpirationDate > purchaseDate)
);

CREATE TABLE purchaseproducts (
  id_purchase INTEGER REFERENCES purchases,
  id_product INTEGER NOT NULL REFERENCES products,
  quantity INTEGER NOT NULL CHECK (quantity > 0),
  cost DECIMAL NOT NULL CHECK (cost > CAST ( 0 AS DECIMAL )),
  PRIMARY KEY(id_purchase, id_product)
);

CREATE TABLE reviews (
  id_product INTEGER NOT NULL REFERENCES products,
  id_purchase INTEGER NOT NULL REFERENCES purchases,
  reviewDate date DEFAULT now() NOT NULL,
  textReview TEXT NOT NULL,
  rating INTEGER NOT NULL CHECK (((rating >= 0) AND (rating <= 5))),
  PRIMARY KEY(id_product, id_purchase)
);

CREATE TABLE brandBrandManagers (
  idBrand INTEGER NOT NULL REFERENCES brands,
  idBrandManager INTEGER NOT NULL REFERENCES brandManagers,
  PRIMARY KEY(idBrand, idBrandManager)
);

 -- Indexes

CREATE INDEX idx_message ON messages USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_product ON products USING hash (name); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_purchase ON purchases USING btree (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX search_idx ON categories USING GIST (to_tsvector('english', categoryName));

 -- Triggers

 --Trigger that prevents an admin from being banned
CREATE FUNCTION ban_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
	IF EXISTS (SELECT * FROM admins WHERE NEW.id_user = admins.id) THEN
		RAISE EXCEPTION 'An Admin can not be banned';
	END IF;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

--Trigger that actualizes the of a product in a purchase according to its actual value
CREATE TRIGGER ban_admin
	BEFORE INSERT OR UPDATE ON bans
	FOR EACH ROW
		EXECUTE PROCEDURE ban_admin();



CREATE FUNCTION purchase_cost() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE purchaseProducts
	SET cost = (SELECT (SELECT price FROM products WHERE id=NEW.id_product) * NEW.quantity) WHERE purchaseProducts.id_product = NEW.id_product AND purchaseProducts.id_purchase = NEW.id_purchase;
	UPDATE purchases
	SET cost = (SELECT SUM(cost2) FROM (SELECT purchaseProducts.cost AS cost2 FROM purchaseProducts WHERE ( purchaseProducts.id_purchase = NEW.id_purchase) ) AS derived_table) WHERE purchases.id = NEW.id_purchase;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;



CREATE TRIGGER purchase_cost
	AFTER INSERT ON purchaseProducts
	FOR EACH ROW
		EXECUTE PROCEDURE purchase_cost();


INSERT INTO users VALUES (DEFAULT, 'Luis', 'Saraiva', 'admin_luissaraiva', 'a_luissaraiva@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Beatriz', 'Henriques', 'admin_beatriz', 'a_beatriz@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Francisco', 'Andrade', 'admin_francisco', 'a_francisco@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Ricardo', 'Abreu', 'admin_ricardo', 'a_ricardo@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Bernardo', 'Leite', 'sprt_bernardoleite', 'sprt_bernardo@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Antonio', 'Pires', 'sprt_antoniopires', 'sprt_antonio@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Jose', 'Cunha', 'sprt_josecunha', 'sprt_jose@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Tomas', 'Costa', 'bm_tomascosta', 'bm_tomas@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Diogo', 'Silva', 'bm_diogosilva', 'bm_diogo@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Joao', 'Monteiro', 'bm_joaomonteiro', 'bm_joao@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Pedro', 'Goncalves', 'pedrogoncalves', 'pedro@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Mariana', 'Oliveira', 'marianaoliveira', 'mariana@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Francisca', 'Rodrigues', 'francisarodrigues', 'francisca@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Ines', 'Pinto', 'inespinto', 'ines@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Raquel', 'Pereira', 'raquelpereira', 'raquel@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Margarida', 'Santos', 'margaridasantos', 'margarida@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Teresa', 'Brito', 'teresabrito', 'teresa@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Tiago', 'Carvalho', 'tiagocarvalho', 'tiago@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Maria', 'Coelho', 'mariacoelho', 'maria@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');
INSERT INTO users VALUES (DEFAULT, 'Ana', 'Ferreira', 'anaferreira', 'ana@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, true, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');


INSERT INTO chatSupports VALUES (5);
INSERT INTO chatSupports VALUES (6);
INSERT INTO chatSupports VALUES (7);


INSERT INTO clients VALUES (11, 923132456);
INSERT INTO clients VALUES (12, 929432849);
INSERT INTO clients VALUES (13, 921232133);
INSERT INTO clients VALUES (14, 912375785);
INSERT INTO clients VALUES (15, 918478539);
INSERT INTO clients VALUES (16, 919453854);
INSERT INTO clients VALUES (17, 919648954);
INSERT INTO clients VALUES (18, 914834304);
INSERT INTO clients VALUES (19, 923456536);
INSERT INTO clients VALUES (20, 924254676);

INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 11);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 5, 11);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 11);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 7, 15);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 7, 15);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 20);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'ChatSupport', 6, 20);


INSERT INTO brands VALUES (DEFAULT, 'Alameda Turquesa', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Aldeia da Roupa Branca', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Alma de Luce', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Ame Moi', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Ana Leite', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Anita Picnic', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Antiflop', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Aparattus', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Babash Design', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Bateye', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Bluf', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Boca do Lobo', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Bordallo Pinheiro', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Briel', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Cabo d Mar', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Candle In', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Cante', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Castelbel', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Cavalinho', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Chicos', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Claus Porto', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Coloradd', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Deamor', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Decenio', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Design Flops', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Doodles', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Dub Dressed', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Ecola', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Enamorata', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Eureka Shoes', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Fasm', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Fio Rosa', 223143243);
INSERT INTO brands VALUES (DEFAULT, 'Science4You', 223143243);

INSERT INTO brandManagers VALUES (1);
INSERT INTO brandManagers VALUES (2);
INSERT INTO brandManagers VALUES (3);
INSERT INTO brandManagers VALUES (4);
INSERT INTO brandManagers VALUES (8);
INSERT INTO brandManagers VALUES (9);
INSERT INTO brandManagers VALUES (10);

INSERT INTO admins VALUES (1);
INSERT INTO admins VALUES (2);
INSERT INTO admins VALUES (3);
INSERT INTO admins VALUES (4);

INSERT INTO bans VALUES (20, 1, DEFAULT);

INSERT INTO categories VALUES (DEFAULT, 'Fashion');
INSERT INTO categories VALUES (DEFAULT, 'Beauty');
INSERT INTO categories VALUES (DEFAULT, 'Technology');
INSERT INTO categories VALUES (DEFAULT, 'Food');
INSERT INTO categories VALUES (DEFAULT, 'Culture');
INSERT INTO categories VALUES (DEFAULT, 'Home');
INSERT INTO categories VALUES (DEFAULT, 'Sports');

INSERT INTO products VALUES (DEFAULT, 'Gelato', 10, now(), 1, 3.0, 30.00, '/images/brands/alameda_turquesa/01-holi-400x400.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1);
INSERT INTO products VALUES (DEFAULT, 'Holi', 10, now(), 1, 3.0, 30.00, '/images/brands/alameda_turquesa/2-alameda-turquesa-gelato-400x400.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1);
INSERT INTO products VALUES (DEFAULT, 'Chizela', 10, now(), 1, 3.0, 30.00, '/images/brands/alameda_turquesa/03-chizela-black-alameda-turquesa-400x400.png', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1);
INSERT INTO products VALUES (DEFAULT, 'Frozen', 10, now(), 1, 3.0, 30.00, '/images/brands/alameda_turquesa/3-frozen-sneakers-alamedaturquesa-400x400.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1);
INSERT INTO products VALUES (DEFAULT, 'Cardosas', 10, now(), 1, 3.0, 300.00, '/images/brands/alma_de_luce/1.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 3, 6);
INSERT INTO products VALUES (DEFAULT, 'Aparador Multi-Gavetas', 10, now(), 1, 3.0, 300.00, '/images/brands/alma_de_luce/3.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 3, 6);


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


INSERT INTO carts VALUES (11, 1, 2);
INSERT INTO carts VALUES (11, 3, 2);
INSERT INTO carts VALUES (11, 2, 2);
INSERT INTO carts VALUES (12, 1, 2);
INSERT INTO carts VALUES (13, 5, 1);
INSERT INTO carts VALUES (13, 2, 2);
INSERT INTO carts VALUES (13, 3, 2);
INSERT INTO carts VALUES (13, 1, 1);
INSERT INTO carts VALUES (14, 2, 1);
INSERT INTO carts VALUES (14, 1, 1);
INSERT INTO carts VALUES (16, 4, 1);
INSERT INTO carts VALUES (16, 2, 2);
INSERT INTO carts VALUES (17, 3, 2);
INSERT INTO carts VALUES (17, 1, 2);
INSERT INTO carts VALUES (18, 4, 1);
INSERT INTO carts VALUES (19, 5, 3);


INSERT INTO countries VALUES (DEFAULT, 'Portugal');
INSERT INTO countries VALUES (DEFAULT, 'Finland');
INSERT INTO countries VALUES (DEFAULT, 'Denmark');
INSERT INTO countries VALUES (DEFAULT, 'Canada');
INSERT INTO countries VALUES (DEFAULT, 'Brazil');
INSERT INTO countries VALUES (DEFAULT, 'Australia');
INSERT INTO countries VALUES (DEFAULT, 'Austria');
INSERT INTO countries VALUES (DEFAULT, 'Poland');
INSERT INTO countries VALUES (DEFAULT, 'Belgium');
INSERT INTO countries VALUES (DEFAULT, 'Switzerland');
INSERT INTO countries VALUES (DEFAULT, 'Italy');
INSERT INTO countries VALUES (DEFAULT, 'Netherlands');
INSERT INTO countries VALUES (DEFAULT, 'Germany');
INSERT INTO countries VALUES (DEFAULT, 'France');
INSERT INTO countries VALUES (DEFAULT, 'Spain');
INSERT INTO countries VALUES (DEFAULT, 'United Kingdom');
INSERT INTO countries VALUES (DEFAULT, 'USA');
INSERT INTO countries VALUES (DEFAULT, 'Greece');
INSERT INTO countries VALUES (DEFAULT, 'Norway');
INSERT INTO countries VALUES (DEFAULT, 'Mozambique');
INSERT INTO countries VALUES (DEFAULT, 'Angola');
INSERT INTO countries VALUES (DEFAULT, 'Ireland');
INSERT INTO countries VALUES (DEFAULT, 'Hungary');
INSERT INTO countries VALUES (DEFAULT, 'Romania');
INSERT INTO countries VALUES (DEFAULT, 'Sweden');
INSERT INTO countries VALUES (DEFAULT, 'Slovenia');

INSERT INTO cities VALUES (DEFAULT, 'Porto', 1);
INSERT INTO cities VALUES (DEFAULT, 'Lamego', 1);
INSERT INTO cities VALUES (DEFAULT, 'Lisboa', 1);
INSERT INTO cities VALUES (DEFAULT, 'Coimbra', 1);
INSERT INTO cities VALUES (DEFAULT, 'Faro', 1);
INSERT INTO cities VALUES (DEFAULT, 'Bragança', 1);
INSERT INTO cities VALUES (DEFAULT, 'Leiria', 1);
INSERT INTO cities VALUES (DEFAULT, 'Viana do Castelo', 1);
INSERT INTO cities VALUES (DEFAULT, 'Braga', 1);
INSERT INTO cities VALUES (DEFAULT, 'Guarda', 1);



INSERT INTO addresses VALUES (DEFAULT, 'Rua Marco de Canaveses 19', '4100-123', 1);
INSERT INTO addresses VALUES (DEFAULT, 'Avenida 5 de Outubro 52', '4312-234', 2);
INSERT INTO addresses VALUES (DEFAULT, 'Rua de Moçambique 138', '4152-164', 4);
INSERT INTO addresses VALUES (DEFAULT, 'Rua Ferreira Lapa 49', '4291-134', 3);
INSERT INTO addresses VALUES (DEFAULT, 'Rua General Alberto Delgado 534', '3125-343', 5);
INSERT INTO addresses VALUES (DEFAULT, 'Rua Professor Egas Moniz 243', '3322-421', 6);
INSERT INTO addresses VALUES (DEFAULT, 'Rua Manuel Simões Maia 123', '2314-432', 7);
INSERT INTO addresses VALUES (DEFAULT, 'Rua dos Poveiros 77', '2151-542', 8);
INSERT INTO addresses VALUES (DEFAULT, 'Rua Damião de Góis 211', '1312-321', 9);
INSERT INTO addresses VALUES (DEFAULT, 'Rua Serpa Pinto 15', '1532-253', 10);


INSERT INTO clientaddresses VALUES (11, 1);
INSERT INTO clientaddresses VALUES (12, 2);
INSERT INTO clientaddresses VALUES (13, 3);
INSERT INTO clientaddresses VALUES (14, 4);
INSERT INTO clientaddresses VALUES (15, 5);
INSERT INTO clientaddresses VALUES (16, 6);
INSERT INTO clientaddresses VALUES (17, 7);
INSERT INTO clientaddresses VALUES (18, 8);
INSERT INTO clientaddresses VALUES (19, 9);
INSERT INTO clientaddresses VALUES (20, 10);


INSERT INTO purchases VALUES (DEFAULT, 11, 1, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 11, 2, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 12, 3, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 212393204);
INSERT INTO purchases VALUES (DEFAULT, 12, 4, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 12, 5, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 15, 6, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 17, 7, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 17, 8, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 19, 9, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 19, 10, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);


INSERT INTO purchaseproducts VALUES (1, 5, 1, 300);
INSERT INTO purchaseproducts VALUES (2, 2, 1, 300);
INSERT INTO purchaseproducts VALUES (2, 3, 1, 300);
INSERT INTO purchaseproducts VALUES (3, 1, 1, 300);
INSERT INTO purchaseproducts VALUES (4, 4, 1, 300);
INSERT INTO purchaseproducts VALUES (5, 1, 1, 300);
INSERT INTO purchaseproducts VALUES (6, 3, 1, 300);
INSERT INTO purchaseproducts VALUES (7, 3, 1, 300);
INSERT INTO purchaseproducts VALUES (8, 2, 1, 300);
INSERT INTO purchaseproducts VALUES (9, 2, 1, 300);
INSERT INTO purchaseproducts VALUES (10, 4, 1, 300);
INSERT INTO purchaseproducts VALUES (3, 3, 1, 300);
INSERT INTO purchaseproducts VALUES (4, 1, 1, 300);
INSERT INTO purchaseproducts VALUES (5, 5, 1, 300);
INSERT INTO purchaseproducts VALUES (6, 1, 1, 300);
INSERT INTO purchaseproducts VALUES (7, 2, 1, 300);
INSERT INTO purchaseproducts VALUES (8, 3, 1, 300);
INSERT INTO purchaseproducts VALUES (9, 4, 1, 300);
INSERT INTO purchaseproducts VALUES (10, 2, 1, 300);

INSERT INTO reviews VALUES (1, 5, DEFAULT, 'First to Comment', 3);
INSERT INTO reviews VALUES (2, 2, DEFAULT, 'Excellent Service', 5);
INSERT INTO reviews VALUES (3, 2, DEFAULT, 'Excellent Service', 5);
INSERT INTO reviews VALUES (4, 10, DEFAULT, 'First to Comment', 4);
INSERT INTO reviews VALUES (2, 8, DEFAULT, 'Horrible Product', 1);
INSERT INTO reviews VALUES (1, 3, DEFAULT, 'Loved this product', 4);
INSERT INTO reviews VALUES (3, 6, DEFAULT, 'Loved this product', 5);
INSERT INTO reviews VALUES (5, 1, DEFAULT, 'First to Comment', 4);
INSERT INTO reviews VALUES (4, 4, DEFAULT, 'Horrible Product', 2);

INSERT INTO brandBrandManagers VALUES (1, 8);
INSERT INTO brandBrandManagers VALUES (2, 9);
INSERT INTO brandBrandManagers VALUES (3, 10);
INSERT INTO brandBrandManagers VALUES (4, 8);
INSERT INTO brandBrandManagers VALUES (5, 9);
INSERT INTO brandBrandManagers VALUES (6, 10);
INSERT INTO brandBrandManagers VALUES (7, 8);
INSERT INTO brandBrandManagers VALUES (8, 9);
INSERT INTO brandBrandManagers VALUES (9, 10);
INSERT INTO brandBrandManagers VALUES (10, 8);
INSERT INTO brandBrandManagers VALUES (11, 9);
INSERT INTO brandBrandManagers VALUES (12, 10);
INSERT INTO brandBrandManagers VALUES (13, 8);
INSERT INTO brandBrandManagers VALUES (14, 9);
INSERT INTO brandBrandManagers VALUES (15, 10);
INSERT INTO brandBrandManagers VALUES (16, 8);
INSERT INTO brandBrandManagers VALUES (17, 9);
INSERT INTO brandBrandManagers VALUES (18, 10);
