
/*SEARCH*/

CREATE VIEW "ListProducts" AS
SELECT p.id AS "ID",p.name AS "Name", p.quantityInStock AS "Quantity In Stock", 
	   p.dateCreated AS "Date Created", p.modelNumber AS "Model Number", p.weight AS "Weight", p.price AS "Price", 
	   p.imageURL AS "Image URL", p.bigDescription AS "Big Description", p.shortDescription AS "Short Description", 
	   (array_agg(pc.categoryName ORDER BY p.id DESC))[1] AS "Category", (array_agg(b.name ORDER BY p.id DESC))[1] AS "Brand", AVG(pr.rating) AS "Rating"
FROM product p, productcategory pc, brand b, productreview pr
WHERE p.id_brand = b.id AND p.id_category = pc.id AND pr.id_product = p.id 
GROUP BY p.id;

CREATE VIEW "ViewProduct" AS
SELECT p.id AS "ID",p.name AS "Name", p.quantityInStock AS "Quantity In Stock", 
	   p.dateCreated AS "Date Created", p.modelNumber AS "Model Number", p.weight AS "Weight", p.price AS "Price", 
	   p.imageURL AS "Image URL", p.bigDescription AS "Big Description", p.shortDescription AS "Short Description", 
	   (array_agg(pc.categoryName ORDER BY p.id DESC))[1] AS "Category", (array_agg(b.name ORDER BY p.id DESC))[1] AS "Brand", AVG(pr.rating) AS "Rating"
FROM product p, productcategory pc, brand b, productreview pr
WHERE p.id_brand = b.id AND p.id_category = pc.id AND pr.id_product = p.id 
AND p.id = 1
GROUP BY p.id;

CREATE VIEW "ListProductsByCategory" AS
SELECT p.id AS "ID",p.name AS "Name", p.quantityInStock AS "Quantity In Stock", 
	   p.dateCreated AS "Date Created", p.modelNumber AS "Model Number", p.weight AS "Weight", p.price AS "Price", 
	   p.imageURL AS "Image URL", p.bigDescription AS "Big Description", p.shortDescription AS "Short Description", 
	   (array_agg(pc.categoryName ORDER BY p.id DESC))[1] AS "Category", (array_agg(b.name ORDER BY p.id DESC))[1] AS "Brand", AVG(pr.rating) AS "Rating"
FROM product p, productcategory pc, brand b, productreview pr
WHERE p.id_brand = b.id AND p.id_category = pc.id AND pr.id_product = p.id 
AND pc.categoryName LIKE '%Fashion%'
GROUP BY p.id;


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


SELECT p.id AS "ID",p.name AS "Name", p.quantityInStock AS "Quantity In Stock", 
	   p.dateCreated AS "Date Created", p.modelNumber AS "Model Number", 
       p.weight AS "Weight", p.price AS "Price", 
	   p.imageURL AS "Image URL", p.bigDescription AS "Big Description", 
       p.shortDescription AS "Short Description", 
	   (array_agg(pc.categoryName ORDER BY p.id DESC))[1] AS "Category", 
       (array_agg(b.name ORDER BY p.id DESC))[1] AS "Brand", AVG(pr.rating) AS "Rating"
FROM products p, categories pc, brands b, reviews pr, (setweight(to_ts_vector(pc.categoryName), 'B') || setweight(to_ts_vector(p.name), 'A')) AS document, plainto_ts_query("Fashion") AS query
WHERE p.id_brand = b.id AND p.id_category = pc.id AND pr.id_product = p.id 
AND document  @@ query
GROUP BY p.id
ORDER BY ts_rank_cd(document, query);

SELECT p.id AS "ID",p.name AS "Name", p.quantityInStock AS "Quantity In Stock", 
	   p.dateCreated AS "Date Created", p.modelNumber AS "Model Number", 
       p.weight AS "Weight", p.price AS "Price", 
	   p.imageURL AS "Image URL", p.bigDescription AS "Big Description", 
       p.shortDescription AS "Short Description", 
	   (array_agg(pc.categoryName ORDER BY p.id DESC))[1] AS "Category", 
       (array_agg(b.brandname ORDER BY p.id DESC))[1] AS "Brand", AVG(pr.rating) AS "Rating", ts_rank_cd(document, query) AS rank
FROM products p, categories pc, brands b, reviews pr, (setweight(to_tsvector(pc.categoryName), 'B') || setweight(to_tsvector(p.name), 'A')) AS document, plainto_tsquery('Fashion') AS query
WHERE p.id_brand = b.id_brand AND p.id_category = pc.id_category AND pr.id_product = p.id 
AND document  @@ query
GROUP BY p.id, document.document, query.query
ORDER BY  rank DESC;

SELECT  ts_rank_cd(document, query) AS rank
FROM  (setweight(to_tsvector('ola'), 'B') || setweight(to_tsvector('adeus'), 'A')) AS document, plainto_tsquery('Fashion') AS query
WHERE document  @@ query
GROUP BY p.id, document.document, query.query
ORDER BY  rank DESC;
