
/*SEARCH*/

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


/* REVIEWS */

CREATE VIEW "ReviewsByProductId" AS
SELECT *
FROM productreview
WHERE id_product= 1;


CREATE VIEW "ReviewsByPurchaseId" AS
SELECT *
FROM productreview
WHERE id_purchase = 1;


/* BRAND */

CREATE VIEW "ListBrands" AS
SELECT *
FROM brand;


CREATE VIEW "BrandProducts" AS
SELECT *
FROM product
WHERE id_brand=(SELECT id FROM brand WHERE name = 'Alameda Turquesa');



/* USERS */

CREATE VIEW "ListUsers" AS
SELECT *
FROM users;


CREATE VIEW "Profile" AS
SELECT *
FROM users
WHERE id = 1;



/* CHAT */

CREATE VIEW "Supports" AS
SELECT *
FROM users
LEFT OUTER JOIN chatSupport
ON users.id = chatSupport.id_chatSupport;



/* BRAND MANAGERS*/

CREATE VIEW "BrandManagers" AS
SELECT *
FROM users
INNER JOIN brandManager
ON users.id = brandManager.id_brandManager;


CREATE VIEW "BrandManagersByBrand" AS
SELECT *
FROM brandManager
WHERE id_brandManager = (SELECT idBrandManager FROM brandBrandManager WHERE idBrand = (SELECT id FROM brand WHERE name='Alameda Turquesa'));



/* CLIENT */

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
