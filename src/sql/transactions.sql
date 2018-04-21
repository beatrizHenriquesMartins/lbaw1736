
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
