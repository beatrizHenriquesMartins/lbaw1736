
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



BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

--Get number of purchases
SELECT COUNT(*)
FROM products ;

--Get products 
SELECT p.id AS "ID",p.name AS "Name", p.quantityInStock AS "Quantity In Stock", 
	   p.dateCreated AS "Date Created",  
        p.price AS "Price", 
	   p.imageURL AS "Image URL", p.bigDescription AS "Big Description", 
       p.shortDescription AS "Short Description", 
	   (array_agg(pc.categoryName ORDER BY p.id DESC))[1] AS "Category", 
       (array_agg(b.brandname ORDER BY p.id DESC))[1] AS "Brand", 
       AVG(pr.rating) AS "Rating"
FROM products p, categories pc, brands b, reviews pr
WHERE p.id_brand = b.id_brand AND p.id_category = pc.id_category AND pr.id_product = p.id 
GROUP BY p.id;

COMMIT;
