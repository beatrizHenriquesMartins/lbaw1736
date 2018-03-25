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
  sender TEXT NOT NULL CHECK(sender = 'chatSupport' OR sender = 'client'),
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
