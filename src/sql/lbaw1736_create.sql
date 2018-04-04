-- Drops
DROP Table IF EXISTS brandBrandManager CASCADE;
DROP TABLE IF EXISTS productreview CASCADE;
DROP TABLE IF EXISTS purchaseproduct CASCADE;
DROP TABLE IF EXISTS purchase CASCADE;
DROP TABLE IF EXISTS clientaddress CASCADE;
DROP TABLE IF EXISTS country CASCADE;
DROP TABLE IF EXISTS city CASCADE;
DROP TABLE IF EXISTS address CASCADE;
DROP TABLE IF EXISTS cartproduct CASCADE;
DROP TABLE IF EXISTS productwishlist CASCADE;
DROP TABLE IF EXISTS product CASCADE;
DROP TABLE IF EXISTS productcategory CASCADE;
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

DROP VIEW IF EXISTS "ListProducts";
DROP VIEW IF EXISTS "ViewProduct";
DROP VIEW IF EXISTS "ListProductsByCategory";
DROP VIEW IF EXISTS "ReviewsByProductId";
DROP VIEW IF EXISTS "ReviewsByPurchaseId";
DROP VIEW IF EXISTS "ListBrands";
DROP VIEW IF EXISTS "BrandProducts";
DROP VIEW IF EXISTS "ListUsers";
DROP VIEW IF EXISTS "Profile";
DROP VIEW IF EXISTS "Supports";
DROP VIEW IF EXISTS "BrandManagers";
DROP VIEW IF EXISTS "BrandManagersByBrand";
DROP VIEW IF EXISTS "WishlistByClientId";
DROP VIEW IF EXISTS "PurchasesByClientId";
DROP VIEW IF EXISTS "ProductsInPurchase";
DROP VIEW IF EXISTS "ProductsInCart";
DROP VIEW IF EXISTS "ClientMessages";

DROP INDEX IF EXISTS idx_users;
DROP INDEX IF EXISTS idx_message;
DROP INDEX IF EXISTS idx_product;
DROP INDEX IF EXISTS idx_productwishlist;
DROP INDEX IF EXISTS idx_cartproduct;
DROP INDEX IF EXISTS idx_purchase;
DROP INDEX IF EXISTS idx_purchaseproduct;
DROP INDEX IF EXISTS idx_productreview;



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
  active BOOLEAN NOT NULL
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

CREATE TABLE productcategory (
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
  id_category INTEGER NOT NULL REFERENCES productcategory
);

CREATE TABLE productwishlist (
  id_product INTEGER REFERENCES product,
  id_client INTEGER REFERENCES client,
  PRIMARY KEY(id_product, id_client)
);

CREATE TABLE cartproduct (
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

CREATE TABLE productreview (
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



-- Queries


CREATE VIEW "ListProducts" AS
SELECT *
FROM product;

CREATE VIEW "ViewProduct" AS
SELECT *
FROM product
WHERE id = 1;

CREATE VIEW "ListProductsByCategory" AS
SELECT *
FROM product
WHERE id_category = (SELECT id FROM productcategory WHERE categoryName = 'Fashion');

CREATE VIEW "ReviewsByProductId" AS
SELECT *
FROM productreview
WHERE id_product= 1;

CREATE VIEW "ReviewsByPurchaseId" AS
SELECT *
FROM productreview
WHERE id_purchase = 1;

CREATE VIEW "ListBrands" AS
SELECT *
FROM brand;

CREATE VIEW "BrandProducts" AS
SELECT *
FROM product
WHERE id_brand=(SELECT id FROM brand WHERE name = 'Alameda Turquesa');

CREATE VIEW "ListUsers" AS
SELECT *
FROM users;

CREATE VIEW "Profile" AS
SELECT *
FROM users
WHERE id = 1;

CREATE VIEW "Supports" AS
SELECT *
FROM users
LEFT OUTER JOIN chatSupport
ON users.id = chatSupport.id_chatSupport;

CREATE VIEW "BrandManagers" AS
SELECT *
FROM users
INNER JOIN brandManager
ON users.id = brandManager.id_brandManager;

CREATE VIEW "BrandManagersByBrand" AS
SELECT *
FROM brandManager
WHERE id_brandManager = (SELECT idBrandManager FROM brandBrandManager WHERE idBrand = (SELECT id FROM brand WHERE name='Alameda Turquesa'));

CREATE VIEW "WishlistByClientId" AS
SELECT product.name, product.price, product.imageURL, client.id_client
FROM product, client, productwishlist
WHERE client.id_client = productwishlist.id_client AND product.id = productwishlist.id_product AND client.id_client = 12;

CREATE VIEW "PurchasesByClientId" AS
SELECT *
FROM purchase
WHERE id_client = 11;

CREATE VIEW "ProductsInPurchase" AS
SELECT product.name, product.price, product.imageURL, purchase.id_client, purchaseproduct.quantity, purchaseproduct.cost
FROM purchase, product, purchaseproduct
WHERE purchase.id = purchaseproduct.id_purchase AND product.id = purchaseproduct.id_product AND purchase.id_client = 12;

CREATE VIEW "ProductsInCart" AS
SELECT product.name, product.price, product.imageURL, client.id_client
FROM product, client, cartproduct
WHERE client.id_client = cartproduct.id_client AND product.id = cartproduct.id_product AND client.id_client = 11;

CREATE VIEW "ClientMessages" AS
SELECT *
FROM message
WHERE id_client = 11;


UPDATE users
SET
 firstName = $firstName,
 lastName = $lastName,
 username = $username,
 email = $email,
 password = $password,
 imageURL = $imageURL,
 dateModified = now()
WHERE id = $id;

INSERT INTO users(id, firstName, lastName, username, email, password, imageURL, dateCreated, dateModified, active)
  VALUES ($id, $firstName, $lastName, $username, $email, $password, $imageURL, dateCreated, dateModified, active);

DELETE FROM admin WHERE id = (SELECT id FROM users WHERE id=$id);

DELETE FROM brandManager WHERE id=$id;

DELETE FROM users WHERE id=$id;

INSERT INTO message (id, message, dateSent, sender, id_chatSupport, id_client)
  VALUES($id, $message, now(), $sender, $id_chatSupport, $id_client);

DELETE FROM message WHERE id=$id;

DELETE FROM brandManager WHERE id_brandManager = (SELECT id FROM users WHERE id=$id);

UPDATE brand
SET
 name=$name,
 contact=$contact
WHERE id=$id;

INSERT INTO brand (id, name, contact)
  VALUES ($id, $name, $contact);

DELETE FROM brandBrandManager WHERE idBrand = (SELECT id FROM brand WHERE name=$name);

DELETE FROM brand WHERE name=$name;

INSERT INTO ban (id_user, id_admin, banDate)
  VALUES ($id_user, $id_admin, $banDate);

DELETE FROM ban WHERE id_user=$id_user;

UPDATE product
SET
 quantityInStock=$quantityInStock,
 modelNumber=$modelNumber,
 weight=$weight,
 price=$price,
 imageURL=$imageURL,
 bigDescription=$bigDescription,
 shortDescription=$shortDescription,
 id_category=$id_category
WHERE id_brand=$id_brand
AND name=$name;

INSERT INTO product(id, name, quantityInStock, modelNumber, weight, price, imageURL, bigDescription, shortDescription, id_brand, id_category)
  VALUES($id, $name, $quantityInStock, $modelNumber, $weight, $price, $imageURL, $bigDescription, $shortDescription, $id_brand, $id_category);

DELETE FROM product WHERE id_product=$id_product;

UPDATE productcategory
SET
 categoryName=$categoryName
WHERE id=$id;

INSERT INTO productreview(id_product, id_purchase, textReview, rating)
  VALUES ($id_product, $id_purchase, $textReview, $rating);

DELETE FROM productreview WHERE id_product=$id_product AND id_purchase=$id_purchase;

DELETE FROM cartproduct WHERE id_client = (SELECT id FROM users WHERE id=$id);

DELETE FROM productwishlist WHERE id_client = (SELECT id FROM users WHERE id=$id);

DELETE FROM client WHERE id_client = (SELECT id FROM users WHERE id=$id);

DELETE FROM users WHERE id=$id;

UPDATE client
SET
 cellphone = $cellphone
WHERE id_client=$id_client;

INSERT INTO client(id_client, cellphone)
  VALUES ($id_client, $cellphone);

INSERT INTO productwishlist (id_product, id_client)
  VALUES ($id_product, $id_client);

DELETE FROM productwishlist WHERE id_product=$id_product AND id_client=$id_client;

UPDATE cartproduct
SET
 quantity=$quantity
WHERE id_product=$id_product AND id_client=$id_client;

INSERT INTO cartproduct (id_client, id_product, quantity)
  VALUES ($id_client, $id_product, $quantity);

DELETE FROM cartproduct WHERE id_product=$id_product AND id_client=$id_client;

INSERT INTO city (id, city, id_country)
  VALUES ($id, $city, $id_country);

INSERT INTO address (id, address, zipcode, id_city)
  VALUES($id, $address, $zipcode, $id_city);

DELETE FROM clientaddress WHERE id_client=$id_client AND id_address=(SELECT id FROM address WHERE address=$address);

DELETE FROM address WHERE address=$address;

INSERT INTO purchase(id, id_client, id_address, purchaseDate, purchaseState, cost, paymentType, cardNumber, cardName, cardExpirationDate, nif)
  VALUES ($id_client,$id_address, $purchaseDate, $purchaseState, $cost, $paymentType, $cardNumber, $cardName, $cardExpirationDate, $nif);

INSERT INTO purchaseproduct (id_purchase, id_product, quantity, cost)
  VALUES ($id_purchase, $id_product, $quantity, $cost);



 -- Indexes

CREATE INDEX idx_users ON users USING hash (id); /*cardinalidade alta-nao se faz cluster*/

CREATE INDEX idx_message ON message USING btree (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_product ON product USING btree (name); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_productwishlist ON productwishlist USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_cartproduct ON cartproduct USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_purchase ON purchase USING btree (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_purchaseproduct ON purchaseproduct USING hash (id_purchase); /*cardinalidade media-nao se faz cluster*/

CREATE INDEX idx_productreview ON productreview USING hash (id_product); /*cardinalidade media-bom candidato para cluster*/



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
