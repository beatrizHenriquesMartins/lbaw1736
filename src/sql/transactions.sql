
BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

--Get number of purchases
SELECT COUNT(*)
FROM purchases ;

--Get products purchased
SELECT products.name, products.price, products.imageURL,
purchaseproducts.quantity, purchaseproducts.cost
FROM purchases, products, purchaseproducts 
	WHERE purchases.id = purchaseproducts.id_purchase
	AND products.id = purchaseproducts.id_product
	AND purchases.id_client = $id_client;

COMMIT;


BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

INSERT INTO users(id, firstName, lastName, username, email, password, imageURL,
	dateCreated, dateModified, active, rememember_token)
VALUES ($id, $firstName, $lastName, $username, $email, $password, $imageURL, 
	DEFAULT, DEFAULT, true, $token);
	
INSERT INTO clients($id, $cellphone);

COMMIT;

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

INSERT INTO purchases(id, id_client, id_address, purchaseDate, purchaseState, 
	cost, paymentType, cardNumber, cardName, cardExpirationDate, nif)
VALUES ($id, $id_client,$id_address, DEFAULT, $purchaseState, 
	$cost, $paymentType, $cardNumber, $cardName, $cardExpirationDate, $nif);
	
INSERT INTO purchaseproducts (id_purchase, id_product, quantity, cost)
VALUES ($id, $id_product, $quantity, $cost);

COMMIT;
