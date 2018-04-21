
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
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

INSERT INTO users(id, firstName, lastName, username, email, password, imageURL,
	dateCreated, dateModified, active, rememember_token)
VALUES ($id, $firstName, $lastName, $username, $email, $password, $imageURL, 
	DEFAULT, DEFAULT, true, $token);
	
INSERT INTO clients($id, $cellphone);

COMMIT;
