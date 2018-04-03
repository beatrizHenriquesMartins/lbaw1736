 
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

 INSERT INTO users(firstName, lastName, email, password, imageURL)
 VALUES ($firstName, $lastName, $email, $password, $imageURL);

/* ADMIN */
DELETE FROM admin WHERE id = (SELECT id FROM users WHERE id=$id);
DELETE FROM users WHERE id=$id;


/* CHAT */
INSERT INTO message (message, dateSent, sender, id_chatSupport, id_client)
VALUES($message, now(), $sender, $id_chatSupport, $id_client);

DELETE FROM message WHERE id=$id;


/* BRAND */

DELETE FROM brandManager WHERE id_brandManager = (SELECT id FROM users WHERE id=$id);

UPDATE brand
SET name=$name,
contact=$contact
WHERE id=$id;

INSERT INTO brand (name, contact)
VALUES ($name, $contact);

DELETE FROM brandBrandManager WHERE idBrand = (SELECT id FROM brand WHERE name=$name);
DELETE FROM brand WHERE name=$name;


/* BAN */
INSERT INTO ban (id_user, id_admin)
VALUES ($id_user, $id_admin);

DELETE FROM ban WHERE id_user=$id_user;

/* PRODUCT */

UPDATE product
SET name=$name,
quantityInStock=$quantityInStock,
modelNumber=$modelNumber,
weight=$weight,
price=$price,
imageURL=$imageURL,
bigDescription=$bigDescription,
shortDescription=$shortDescription
WHERE id_brand=$id_brand
AND id_category=$id_category;

INSERT INTO product(name, quantityInStock, modelNumber, weight, price, imageURL, bigDescription, shortDescription, id_brand, id_category)
VALUES($name, $quantityInStock, $modelNumber, $weight, $price, $imageURL, $bigDescription, $shortDescription, $id_brand, $id_category);

DELETE FROM product WHERE name=$name;

UPDATE productcategory
SET categoryName=$categoryName
WHERE id=$id;

INSERT INTO productcategory (categoryName)
VALUES ($categoryName);

INSERT INTO productreview(id_product, id_purchase, textReview, rating)
VALUES ($id_product, $id_purchase, $textReview, $rating);

DELETE FROM productreview WHERE id_product=$id_product AND id_purchase=$id_purchase;


/* CLIENT */
DELETE FROM client WHERE id_client = (SELECT id FROM users WHERE id=$id);
DELETE FROM users WHERE id=$id;

UPDATE client
SET cellphone = $cellphone
WHERE id=$id;

INSERT INTO client(cellphone)
VALUES ($cellphone);

INSERT INTO productwishlist (id_product, id_client)
VALUES ($id_product, $id_client);

DELETE FROM productwishlist WHERE id_product=$id_product AND id_client=$id_client;

UPDATE cartproduct
SET quantity=$quantity
WHERE id_product=$id_product;

INSERT INTO cartproduct (id_client, id_product, quantity)
VALUES ($id_client, $id_product, $quantity);

DELETE FROM cartproduct WHERE id_product=$id_product;

/* ADDRESS */
INSERT INTO city (city, id_country)
VALUES ($city, $id_country=(SELECT id FROM country WHERE country=$country));

INSERT INTO address (address, zipcode, id_city)
VALUES($address, $zipcode, $id_city);

DELETE FROM clientaddress WHERE id_client=$id_client AND id_address=(SELECT id FROM address WHERE address=$address);
DELETE FROM address WHERE address=$address;

/* PURCHASE */
INSERT INTO purchase(id_client, id_address, purchaseState, cost, paymentType, cardNumber, cardName, cardExpirationDate, nif)
VALUES ($id_client,$id_address,$purchaseState, $cost, $paymentType, $cardNumber, $cardName, $cardExpirationDate, $nif);

INSERT INTO (id_purchase, id_product, quantity, cost)
VALUES ($id_purchase, $id_product, $quantity, $cost);
