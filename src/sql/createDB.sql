DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS representing;
DROP TABLE IF EXISTS brandManager;
DROP TABLE IF EXISTS brand;
DROP TABLE IF EXISTS cartproduct;
DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS clientaddress;
DROP TABLE IF EXISTS purchaseproduct;
DROP TABLE IF EXISTS purchase;
DROP TABLE IF EXISTS productreview;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS chat;
DROP TABLE IF EXISTS chatSupport;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS productwishlist;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS wishlist;
DROP TABLE IF EXISTS address;

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  firstName TEXT NOT NULL,
  lastName TEXT NOT NULL,
  username TEXT NOT NULL UNIQUE,
  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  imageURL TEXT NOT NULL,
  dateCreated TIMESTAMP DEFAULT now() NOT NULL,
  dateModified TIMESTAMP NOT NULL,
  active BOOLEAN NOT NULL
);

CREATE TABLE chatSupport (
  id INTEGER PRIMARY KEY REFERENCES users
);

CREATE TABLE chat (
  id SERIAL PRIMARY KEY,
  id_chatSupport INTEGER REFERENCES chatSupport
);

CREATE TABLE message (
  id SERIAL PRIMARY KEY,
  message TEXT NOT NULL,
  dateSent TIMESTAMP DEFAULT now() NOT NULL,
  id_chat INTEGER NOT NULL REFERENCES chat,
  sender TEXT NOT NULL
);

CREATE TABLE client (
  id INTEGER PRIMARY KEY REFERENCES users,
  nif INTEGER NOT NULL,
  cellphone INTEGER,
  id_chat INTEGER UNIQUE REFERENCES chat
);

CREATE TABLE brandManager (
  id INTEGER PRIMARY KEY REFERENCES users
);

CREATE TABLE admin (
  id INTEGER PRIMARY KEY REFERENCES brandManager
);

CREATE TABLE brand (
  id SERIAL PRIMARY KEY,
  contact INTEGER NOT NULL
);

CREATE TABLE representing (
  id_brandManager INTEGER REFERENCES brandManager,
  id_brand INTEGER REFERENCES brand,
  PRIMARY KEY(id_brandManager, id_brand)
);

CREATE TABLE product (
  id SERIAL PRIMARY KEY,
  name TEXT UNIQUE,
  quantityStock INTEGER NOT NULL DEFAULT 0,
  dateCreated TIMESTAMP DEFAULT now() NOT NULL,
  modelNumber INTEGER NOT NULL,
  weight DECIMAL NOT NULL,
  price MONEY NOT NULL,
  imageURL TEXT NOT NULL UNIQUE,
  bigDescription TEXT NOT NULL,
  shorDescription TEXT NOT NULL,
  id_brand INTEGER NOT NULL
);

CREATE TABLE wishlist (
  id SERIAL PRIMARY KEY,
  id_client INTEGER REFERENCES client UNIQUE NOT NULL
);

CREATE TABLE productwishlist (
  id_product INTEGER REFERENCES product,
  id_wishlist INTEGER REFERENCES wishlist,
  PRIMARY KEY(id_product, id_wishlist)

);

CREATE TABLE cart (
  id SERIAL PRIMARY KEY,
  id_client INTEGER REFERENCES client UNIQUE NOT NULL
);

CREATE TABLE cartproduct (
  id_cart INTEGER REFERENCES cart,
  id_product INTEGER REFERENCES product,
  quantity INTEGER NOT NULL,
  PRIMARY KEY(id_cart, id_product)
);

CREATE TABLE address (
  id SERIAL PRIMARY KEY,
  address TEXT NOT NULL,
  City TEXT NOT NULL,
  Country TEXT NOT NULL,
  State TEXT NOT NULL,
  ZipCode TEXT NOT NULL
);

CREATE TABLE clientaddress (
  id_client INTEGER REFERENCES client,
  id_address INTEGER REFERENCES address,
  PRIMARY KEY(id_client, id_address)
);

CREATE TABLE purchase (
  id SERIAL PRIMARY KEY,
  id_client INTEGER REFERENCES client UNIQUE NOT NULL,
  id_address INTEGER REFERENCES address NOT NULL,
  purchaseDate TIMESTAMP DEFAULT now() NOT NULL,
  state TEXT NOT NULL,
  paymentType TEXT NOT NULL,
  cardNumber TEXT NOT NULL UNIQUE,
  cardName TEXT NOT NULL,
  cardExpirationDate TIMESTAMP NOT NULL,
  paymentStatus TEXT NOT NULL
);

CREATE TABLE purchaseproduct (
  id_purchase INTEGER REFERENCES purchase,
  id_product INTEGER REFERENCES product,
  id_client INTEGER REFERENCES client,
  quantity INTEGER NOT NULL,
  cost INTEGER NOT NULL,
  PRIMARY KEY(id_purchase, id_product)
);

CREATE TABLE productreview (
  id SERIAL PRIMARY KEY,
  id_product INTEGER REFERENCES product,
  id_client INTEGER REFERENCES client,
  reviewDate TIMESTAMP DEFAULT now() NOT NULL,
  textReview TEXT NOT NULL,
  rating INTEGER NOT NULL
);
