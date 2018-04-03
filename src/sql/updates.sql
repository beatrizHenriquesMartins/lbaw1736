
 /* USERS */
 UPDATE users
 SET firstName = $firstName,
 lastName = $lastName,
 username = $username,
 email = $email,
 password = $password,
 imageURL = $imageURL,
 dateModified = now()
 WHERE id = $id;

 INSERT INTO users(id, firstName, lastName, username, email, password, imageURL, dateCreated, dateModified, active)
 VALUES ($id, $firstName, $lastName, $username, $email, $password, $imageURL, dateCreated, dateModified, active);

/* ADMIN */
DELETE FROM admin WHERE id = (SELECT id FROM users WHERE id=$id);
DELETE FROM brandManager WHERE id=$id;
DELETE FROM users WHERE id=$id;


/* CHAT */
INSERT INTO message (id, message, dateSent, sender, id_chatSupport, id_client)
VALUES($id, $message, now(), $sender, $id_chatSupport, $id_client);

DELETE FROM message WHERE id=$id;


/* BRAND */

DELETE FROM brandManager WHERE id_brandManager = (SELECT id FROM users WHERE id=$id);

UPDATE brand
SET name=$name,
contact=$contact
WHERE id=$id;

INSERT INTO brand (id, name, contact)
VALUES ($id, $name, $contact);

DELETE FROM brandBrandManager WHERE idBrand = (SELECT id FROM brand WHERE name=$name);
DELETE FROM brand WHERE name=$name;


/* BAN */
INSERT INTO ban (id_user, id_admin, banDate)
VALUES ($id_user, $id_admin, $banDate);

DELETE FROM ban WHERE id_user=$id_user;

/* PRODUCT */

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
AND name=$name,;

INSERT INTO product(id, name, quantityInStock, modelNumber, weight, price, imageURL, bigDescription, shortDescription, id_brand, id_category)
VALUES($id, $name, $quantityInStock, $modelNumber, $weight, $price, $imageURL, $bigDescription, $shortDescription, $id_brand, $id_category);


UPDATE productcategory
SET categoryName=$categoryName
WHERE id=$id;

INSERT INTO productreview(id_product, id_purchase, textReview, rating)
VALUES ($id_product, $id_purchase, $textReview, $rating);

DELETE FROM productreview WHERE id_product=$id_product AND id_purchase=$id_purchase;


/* CLIENT */
DELETE FROM cartproduct WHERE id_client = (SELECT id FROM users WHERE id=$id);
DELETE FROM productwishlist WHERE id_client = (SELECT id FROM users WHERE id=$id);
DELETE FROM client WHERE id_client = (SELECT id FROM users WHERE id=$id);
DELETE FROM users WHERE id=$id;

UPDATE client
SET cellphone = $cellphone
WHERE id_client=$id_client;

INSERT INTO client(id_client, cellphone)
VALUES ($id_client, $cellphone);

INSERT INTO productwishlist (id_product, id_client)
VALUES ($id_product, $id_client);

DELETE FROM productwishlist WHERE id_product=$id_product AND id_client=$id_client;

UPDATE cartproduct
SET quantity=$quantity
WHERE id_product=$id_product AND id_client=$id_client;

INSERT INTO cartproduct (id_client, id_product, quantity)
VALUES ($id_client, $id_product, $quantity);

DELETE FROM cartproduct WHERE id_product=$id_product AND id_client=$id_client;

/* ADDRESS */
INSERT INTO city (id, city, id_country)
VALUES ($id, $city, $id_country);

INSERT INTO address (id, address, zipcode, id_city)
VALUES($id, $address, $zipcode, $id_city);

DELETE FROM clientaddress WHERE id_client=$id_client AND id_address=(SELECT id FROM address WHERE address=$address);
DELETE FROM address WHERE address=$address;

/* PURCHASE */
INSERT INTO purchase(id, id_client, id_address, purchaseDate, purchaseState, cost, paymentType, cardNumber, cardName, cardExpirationDate, nif)
VALUES ($id_client,$id_address, $purchaseDate, $purchaseState, $cost, $paymentType, $cardNumber, $cardName, $cardExpirationDate, $nif);

INSERT INTO purchaseproduct (id_purchase, id_product, quantity, cost)
VALUES ($id_purchase, $id_product, $quantity, $cost);
