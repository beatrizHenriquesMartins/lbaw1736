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
DROP TABLE IF EXISTS confirmationpayments CASCADE;


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
  remember_token TEXT,
  birthday DATE

);

CREATE TABLE chatSupports (
  id_chatSupport INTEGER PRIMARY KEY REFERENCES users
);

CREATE TABLE clients (
  id_client INTEGER PRIMARY KEY REFERENCES users,
  cellphone BIGINT,
	age INTEGER
);

CREATE TABLE messages (
  id SERIAL PRIMARY KEY,
  message TEXT NOT NULL,
  dateSent TIMESTAMP DEFAULT now() NOT NULL,
  sender TEXT NOT NULL CHECK((sender = ANY (ARRAY['Client'::text, 'chatSupport'::text]))),
  id_chatSupport INTEGER NOT NULL REFERENCES chatSupports,
  id_client INTEGER NOT NULL REFERENCES clients
);

CREATE TABLE brands (
  id_brand SERIAL PRIMARY KEY,
  brandname TEXT NOT NULL UNIQUE,
  contact INTEGER NOT NULL,
  brandimgurl TEXT NOT NULL
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
  id_category SERIAL PRIMARY KEY,
  categoryName TEXT NOT NULL UNIQUE
);

CREATE TABLE products (
  id SERIAL PRIMARY KEY,
  name TEXT UNIQUE NOT NULL,
  quantityinstock INTEGER NOT NULL DEFAULT 0,
  dateCreated TIMESTAMP DEFAULT now() NOT NULL,
  price DECIMAL NOT NULL,
  imageURL TEXT NOT NULL UNIQUE,
  bigDescription TEXT NOT NULL,
  shortDescription TEXT NOT NULL,
  id_brand INTEGER NOT NULL REFERENCES brands,
  id_category INTEGER NOT NULL REFERENCES categories,
  active INTEGER NOT NULL,
  tocarousel INTEGER NOT NULL
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
  id_country SERIAL PRIMARY KEY,
  country TEXT NOT NULL UNIQUE
);

CREATE TABLE cities (
  id_city SERIAL PRIMARY KEY,
  city TEXT NOT NULL,
  id_country INTEGER NOT NULL REFERENCES countries
);

CREATE TABLE addresses (
  id_address SERIAL PRIMARY KEY,
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
  id_purchase SERIAL PRIMARY KEY,
  id_client INTEGER REFERENCES clients NOT NULL,
  id_address INTEGER REFERENCES addresses NOT NULL,
  purchase_date TIMESTAMP DEFAULT now() NOT NULL,
  purchase_state BOOLEAN NOT NULL,
  cost DECIMAL NOT NULL CHECK (cost > CAST ( 0 AS DECIMAL )),
  paymentType TEXT DEFAULT 'Unknown' NOT NULL,
  cardNumber TEXT DEFAULT 'Unknown' NOT NULL,
  cardName TEXT DEFAULT 'Unknown' NOT NULL,
  cardExpirationDate TIMESTAMP DEFAULT '2999-12-31' NOT NULL,
  nif INTEGER DEFAULT 0
  --,CHECK (cardExpirationDate > purchaseDate)
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
  rating INTEGER NOT NULL CHECK (((rating >= 0) AND (rating <= 5))) DEFAULT 0,
  PRIMARY KEY(id_product, id_purchase)
);

CREATE TABLE brandBrandManagers (
  id_Brand INTEGER NOT NULL REFERENCES brands,
  id_BrandManager INTEGER NOT NULL REFERENCES brandManagers,
  PRIMARY KEY(id_Brand, id_BrandManager)
);



 -- Indexes

CREATE INDEX idx_message ON messages USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_product ON products USING hash (name); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_purchase ON purchases USING btree (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX searchbigdescription_idx ON products USING GIST (to_tsvector('english', bigDescription));

CREATE INDEX searchshortdescription_idx ON products USING GIST (to_tsvector('english', shortDescription));

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


CREATE TRIGGER ban_admin
	BEFORE INSERT OR UPDATE ON bans
	FOR EACH ROW
		EXECUTE PROCEDURE ban_admin();






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
INSERT INTO users VALUES (DEFAULT, 'Ana', 'Ferreira', 'anaferreira', 'ana@gmail.com', '$2y$10$uvSo3QqoE.Y2YFACSQEtoepb8bEBfFltqM/TTiwL7jEQ1GnZLmkza', '/images/user_image.png', DEFAULT, DEFAULT, false, 'Fln3z44jqF0j5ozkNvsEnSPMrPTRA1eYNiDt8FjZnYcxAWuh0OR8iELp81mQ');


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
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'chatSupport', 5, 11);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 11);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'chatSupport', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'chatSupport', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 12);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'chatSupport', 7, 15);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 7, 15);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'chatSupport', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'chatSupport', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 5, 18);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'Client', 6, 20);
INSERT INTO messages VALUES (DEFAULT, 'teste msg', DEFAULT, 'chatSupport', 6, 20);


INSERT INTO brands VALUES (DEFAULT, 'Alameda Turquesa', 223143243, '/images/brands/alameda_turquesa/alameda_turquesa.png');
INSERT INTO brands VALUES (DEFAULT, 'Aldeia da Roupa Branca', 223143243, '/images/brands/aldeia_da_roupa_branca/aldeia_da_roupa_branca.png');
INSERT INTO brands VALUES (DEFAULT, 'Alma de Luce', 223143243, '/images/brands/alma_de_luce/alma_de_luce.png');
INSERT INTO brands VALUES (DEFAULT, 'Ame Moi', 223143243, '/images/brands/ame_moi/ame_moi.png');
INSERT INTO brands VALUES (DEFAULT, 'Ana Leite', 223143243, '/images/brands/ana_leite/ana_leite.png');
INSERT INTO brands VALUES (DEFAULT, 'Anita Picnic', 223143243, '/images/brands/anita_picnic/anita_picnic.png');
INSERT INTO brands VALUES (DEFAULT, 'Antiflop', 223143243, '/images/brands/antiflop/antiflop.png');
INSERT INTO brands VALUES (DEFAULT, 'Aparattus', 223143243, '/images/brands/aparattus/aparattus.png');
INSERT INTO brands VALUES (DEFAULT, 'Babash Design', 223143243, '/images/brands/babash_design/babash_design.png');
INSERT INTO brands VALUES (DEFAULT, 'Bateye', 223143243, '/images/brands/bateye/bateye.png');
INSERT INTO brands VALUES (DEFAULT, 'Bluf', 223143243, '/images/brands/bluf/bluf.png');
INSERT INTO brands VALUES (DEFAULT, 'Boca do Lobo', 223143243, '/images/brands/boca_do_lobo/boca_do_lobo.png');
INSERT INTO brands VALUES (DEFAULT, 'Bordallo Pinheiro', 223143243, '/images/brands/bordallo_pinheiro/bordallo_pinheiro.png');
INSERT INTO brands VALUES (DEFAULT, 'Briel', 223143243, '/images/brands/briel/briel.png');
INSERT INTO brands VALUES (DEFAULT, 'Cabo d Mar', 223143243, '/images/brands/cado_d_mar/cado_d_mar.png');
INSERT INTO brands VALUES (DEFAULT, 'Candle In', 223143243, '/images/brands/candle_in/candle_in.png');
INSERT INTO brands VALUES (DEFAULT, 'Cante', 223143243, '/images/brands/cante/cante.png');
INSERT INTO brands VALUES (DEFAULT, 'Castelbel', 223143243, '/images/brands/castelbel/castelbel.png');
INSERT INTO brands VALUES (DEFAULT, 'Cavalinho', 223143243, '/images/brands/cavalinho/cavalinho.png');
INSERT INTO brands VALUES (DEFAULT, 'Chicos', 223143243, '/images/brands/chicos/chicos.png');
INSERT INTO brands VALUES (DEFAULT, 'Claus Porto', 223143243, '/images/brands/claus_porto/claus_porto.png');
INSERT INTO brands VALUES (DEFAULT, 'Coloradd', 223143243, '/images/brands/coloradd/coloradd.png');
INSERT INTO brands VALUES(DEFAULT, 'Compal', 223143243, '/images/brands/compal/compal.jpg');
INSERT INTO brands VALUES (DEFAULT, 'Deamor', 223143243, '/images/brands/deamor/deamor.png');
INSERT INTO brands VALUES (DEFAULT, 'Decenio', 223143243, '/images/brands/decenio/decenio.png');
INSERT INTO brands VALUES (DEFAULT, 'Design Flops', 223143243, '/images/brands/design_flops/design_flops.png');
INSERT INTO brands VALUES (DEFAULT, 'Doodles', 223143243, '/images/brands/doodles/doodles.png');
INSERT INTO brands VALUES (DEFAULT, 'Dub Dressed', 223143243, '/images/brands/dub_dressed/dub_dressed.png');
INSERT INTO brands VALUES (DEFAULT, 'Ecola', 223143243, '/images/brands/ecola/ecola.png');
INSERT INTO brands VALUES (DEFAULT, 'Enamorata', 223143243, '/images/brands/enamorata/enamorata.png');
INSERT INTO brands VALUES (DEFAULT, 'Eureka Shoes', 223143243, '/images/brands/eureka_shoes/eureka_shoes.png');
INSERT INTO brands VALUES (DEFAULT, 'Fasm', 223143243, '/images/brands/fasm/fasm.png');
INSERT INTO brands VALUES (DEFAULT, 'Fio Rosa', 223143243, '/images/brands/fio_rosa/fio_rosa.png');
INSERT INTO brands VALUES (DEFAULT, 'Science4You', 223143243, '/images/brands/science4you/science4you.png');
INSERT INTO brands VALUES (DEFAULT, 'Spausa', 223143243, '/images/brands/spausa/spausa.png');

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

INSERT INTO products VALUES (DEFAULT, 'Gelato', 10, now(), 30.00, '/images/brands/alameda_turquesa/01-holi-400x400.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1, 1, 0);
INSERT INTO products VALUES (DEFAULT, 'Holi', 10, now(), 30.00, '/images/brands/alameda_turquesa/2-alameda-turquesa-gelato-400x400.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1, 1, 0);
INSERT INTO products VALUES (DEFAULT, 'Chizela', 10, now(), 30.00, '/images/brands/alameda_turquesa/03-chizela-black-alameda-turquesa-400x400.png', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1, 1, 0);
INSERT INTO products VALUES (DEFAULT, 'Frozen', 10, now(), 30.00, '/images/brands/alameda_turquesa/3-frozen-sneakers-alamedaturquesa-400x400.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 1, 1, 1, 0);
INSERT INTO products VALUES (DEFAULT, 'Cardosas', 10, now(), 300.00, '/images/brands/alma_de_luce/1.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 3, 6, 1, 1);
INSERT INTO products VALUES (DEFAULT, 'Aparador Multi-Gavetas', 10, now(), 300.00, '/images/brands/alma_de_luce/2.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 3, 6, 1, 1);
INSERT INTO products VALUES (DEFAULT, 'Cesta Picnic', 10, now(), 10.10, '/images/brands/anita_picnic/slideshow_9.jpg', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.', 'É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica.', 6, 6, 1, 1);
INSERT INTO products VALUES (DEFAULT, 'Sabonete Frangipani', 10, now(), 18.50, '/images/brands/deamor/sabonete_frangipani.jpg', 'DeAmor é um sabonete cremoso, foi especialmente formulado para a pele delicada do teu rosto, quando entra em contacto com a água, liberta uma espuma suave, hidratante e delicada.

Combinando as fragrâncias mais requintadas com os melhores óleos e manteigas vegetais, o sabonete “Frangipani” oferece uma limpeza profunda, deixando a pele preparada para receber os benefícios de beleza diários.

Temos a certeza que o segredo para uma pele saudável e bonita é a limpeza.

Cunhado e embalado manualmente.

É único e especial como tu.

Uso Diário.', 'Combinando as fragrâncias mais requintadas com os melhores óleos e manteigas vegetais, o sabonete “Frangipani” oferece uma limpeza profunda, deixando a pele preparada para receber os benefícios de beleza diários.', 24, 2, 1, 0);

INSERT INTO products VALUES (DEFAULT, 'Sabonete Violeta', 10, now(), 18.50, '/images/brands/deamor/sabonete_violeta.jpg', 'DeAmor é um sabonete cremoso, foi especialmente formulado para a pele delicada do teu rosto, quando entra em contacto com a água, liberta uma espuma suave, hidratante e delicada.

Combinando as fragrâncias mais requintadas com os melhores óleos e manteigas vegetais, o sabonete “Violeta” oferece uma limpeza profunda, deixando a pele preparada para receber os benefícios de beleza diários.

Temos a certeza que o segredo para uma pele saudável e bonita é a limpeza.

Cunhado e embalado manualmente.

É único e especial como tu.

Uso Diário.', 'Combinando as fragrâncias mais requintadas com os melhores óleos e manteigas vegetais, o sabonete “Violeta” oferece uma limpeza profunda, deixando a pele preparada para receber os benefícios de beleza diários.', 24, 2, 1, 0);

INSERT INTO products VALUES (DEFAULT, 'Sabonete Gardénia', 10, now(), 18.50, '/images/brands/deamor/sabonete_gardenia.jpg', 'DeAmor é um sabonete cremoso, foi especialmente formulado para a pele delicada do teu rosto, quando entra em contacto com a água, liberta uma espuma suave, hidratante e delicada.

Combinando as fragrâncias mais requintadas com os melhores óleos e manteigas vegetais, o sabonete “Gardénia” oferece uma limpeza profunda, deixando a pele preparada para receber os benefícios de beleza diários.

Temos a certeza que o segredo para uma pele saudável e bonita é a limpeza.

Cunhado e embalado manualmente.

É único e especial como tu.

Uso Diário.', 'Combinando as fragrâncias mais requintadas com os melhores óleos e manteigas vegetais, o sabonete “Gardénia” oferece uma limpeza profunda, deixando a pele preparada para receber os benefícios de beleza diários.', 24, 2, 1, 0);

INSERT INTO products VALUES (DEFAULT, 'Creme Dia Ouro', 10, now(), 39.40, '/images/brands/spausa/creme_dia_ouro.jpg', 'Corrige as rugas até 29%, em 30 dias e a perda de firmeza, num só gesto. Nutre, ilumina e melhora a elasticidade cutânea. Melhoria na textura da pele em cerca de 113%, mais lisa e aveludada*. Aumento da comunicação intercelular entre as células epidérmicas em 91%*. Restaura os níveis e estimula a produção de Colagénio tipo I, III e IV**.', 'Creme de rosto com SPF 15, que promove a regeneração celular e uma textura acetinada e luminosa, reduzindo as rugas e os sinais de envelhecimento. Em apenas 30 é capaz de reduzir as rugas até 29%', 35, 2, 1, 0);

INSERT INTO products VALUES (DEFAULT, 'Drone Blocks', 10, now(), 49.99, '/images/brands/science4you/drone_blocks.jpg', 'Os drones parecem ter surgido de um dia para o outro nas nossas vidas mas a verdade é que estes pequenos “aviões”, controlados à distância, surgiram pela primeira vez para fins militares. Estes pequenos veículos aéreos não tripulados são controlados por meios eletrónicos e computacionais e foram pensados e construídos para serem usados em missões normalmente de alto risco para humanos. Hoje em dia os drones são usados para fins lúdicos e além das corridas que se podem fazer com eles, os drones com câmaras permitem também tirar fotografias e fazer vídeos incríveis. Nas lojas Science4you pode encontrar os melhores drones para quem procura diversão. O Drone4you, o drone da Science4you, é um brinquedo educativo que ajuda a desenvolver a concentração, o raciocínio e a interação social. E como os nossos drones são os melhores, não poderiamos deixar de incluir em cada aparelho um livro educativo com curiosidades sobre este brinquedo e as funcionalidades deste avião aéreo.', 'Constituído por diversas peças de montar, vais poder construir o teu próprio Drone4you II Blocks consoante a tua imaginação. Constrói, destrói e volta a construir. Personaliza-o com as tuas peças e diverte-te a fazer as acrobacias mais incríveis.', 34, 3, 1, 0);

INSERT INTO products VALUES (DEFAULT, 'Drone Nano', 10, now(), 49.99, '/images/brands/science4you/drone_nano.jpg', 'Os drones parecem ter surgido de um dia para o outro nas nossas vidas mas a verdade é que estes pequenos “aviões”, controlados à distância, surgiram pela primeira vez para fins militares. Estes pequenos veículos aéreos não tripulados são controlados por meios eletrónicos e computacionais e foram pensados e construídos para serem usados em missões normalmente de alto risco para humanos. Hoje em dia os drones são usados para fins lúdicos e além das corridas que se podem fazer com eles, os drones com câmaras permitem também tirar fotografias e fazer vídeos incríveis. Nas lojas Science4you pode encontrar os melhores drones para quem procura diversão. O Drone4you, o drone da Science4you, é um brinquedo educativo que ajuda a desenvolver a concentração, o raciocínio e a interação social. E como os nossos drones são os melhores, não poderiamos deixar de incluir em cada aparelho um livro educativo com curiosidades sobre este brinquedo e as funcionalidades deste avião aéreo.', 'Pequeno em tamanho mas inteligente e cheio de energia, o Drone4you II Nano oferece-te toda a qualidade numa dimensão mini. Grava vídeos HD ou tira fantásticas fotografias com este drone pequeno e versátil.', 34, 3, 1, 0);

INSERT INTO products VALUES (DEFAULT, 'Drone XL', 10, now(), 149.99, '/images/brands/science4you/drone_xl.png', 'Os drones parecem ter surgido de um dia para o outro nas nossas vidas mas a verdade é que estes pequenos “aviões”, controlados à distância, surgiram pela primeira vez para fins militares. Estes pequenos veículos aéreos não tripulados são controlados por meios eletrónicos e computacionais e foram pensados e construídos para serem usados em missões normalmente de alto risco para humanos. Hoje em dia os drones são usados para fins lúdicos e além das corridas que se podem fazer com eles, os drones com câmaras permitem também tirar fotografias e fazer vídeos incríveis. Nas lojas Science4you pode encontrar os melhores drones para quem procura diversão. O Drone4you, o drone da Science4you, é um brinquedo educativo que ajuda a desenvolver a concentração, o raciocínio e a interação social. E como os nossos drones são os melhores, não poderiamos deixar de incluir em cada aparelho um livro educativo com curiosidades sobre este brinquedo e as funcionalidades deste avião aéreo.', 'Com ecrã LCD, câmara HD, rotação 360º, controlo remoto de quatro canais e sistema de equilíbrio inteligente, o Drone4you II XL vai permitir-te fazer fantásticas acrobacias aéreas, agora em alta definição!', 34, 3, 1, 0);

INSERT INTO products VALUES (DEFAULT, 'Drone II', 10, now(), 99.99, '/images/brands/science4you/drone2.png', 'Os drones parecem ter surgido de um dia para o outro nas nossas vidas mas a verdade é que estes pequenos “aviões”, controlados à distância, surgiram pela primeira vez para fins militares. Estes pequenos veículos aéreos não tripulados são controlados por meios eletrónicos e computacionais e foram pensados e construídos para serem usados em missões normalmente de alto risco para humanos. Hoje em dia os drones são usados para fins lúdicos e além das corridas que se podem fazer com eles, os drones com câmaras permitem também tirar fotografias e fazer vídeos incríveis. Nas lojas Science4you pode encontrar os melhores drones para quem procura diversão. O Drone4you, o drone da Science4you, é um brinquedo educativo que ajuda a desenvolver a concentração, o raciocínio e a interação social. E como os nossos drones são os melhores, não poderiamos deixar de incluir em cada aparelho um livro educativo com curiosidades sobre este brinquedo e as funcionalidades deste avião aéreo.', 'Com as luzes LED coloridas, diverte-te a telecomandar o teu drone tanto de dia, como de noite! Com cartão de memória de 4G, este modelo é ideal para iniciantes, sejam crianças ou adultos.', 34, 3, 1, 0);


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


INSERT INTO purchases VALUES (DEFAULT, 11, 1, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 11, 2, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 12, 3, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 212393204);
INSERT INTO purchases VALUES (DEFAULT, 12, 4, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 12, 5, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 15, 6, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 17, 7, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 17, 8, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 19, 9, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);
INSERT INTO purchases VALUES (DEFAULT, 19, 10, DEFAULT, TRUE, 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482);


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
INSERT INTO brandBrandManagers VALUES (34, 1);
INSERT INTO brandBrandManagers VALUES (35, 1);
INSERT INTO brandBrandManagers VALUES (23, 1);
