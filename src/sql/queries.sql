
/*SEARCH*/

CREATE VIEW "ListProducts" AS
SELECT *
FROM product;


CREATE VIEW "ViewProduct" AS
SELECT *
FROM ListProducts
WHERE id='productId';


CREATE VIEW "ListProductsByCategory" AS
SELECT *
FROM product
WHERE id_category = (SELECT id FROM productcategory WHERE categoryName = 'Fashion');


CREATE VIEW "ViewProductInCategory" AS
SELECT *
FROM ListProductsByCategory
WHERE id='productId';



/* REVIEWS */

CREATE VIEW "ReviewsByProductId" AS
SELECT *
FROM productreview
WHERE id_product='productId';


CREATE VIEW "ReviewsByPurchaseId" AS
SELECT *
FROM productreview
WHERE id_purchase='purchaseId';


/* BRAND */

CREATE VIEW "ListBrands" AS
SELECT *
FROM brand;


CREATE VIEW "BrandProducts" AS
SELECT *
FROM product
WHERE id_brand=(SELECT id FROM brand WHERE name='brandName');



/* USERS */

CREATE VIEW "ListUsers" AS
SELECT *
FROM users;


CREATE VIEW "Profile" AS
SELECT *
FROM users
WHERE id = 'userId';



/* CHAT */

CREATE VIEW "Supports" AS
SELECT *
FROM users
WHERE id = (SELECT id FROM chatSupport);



/* BRAND MANAGERS*/

CREATE VIEW "BrandManagers" AS
SELECT *
FROM users
WHERE id = (SELECT id FROM brandManager);


CREATE VIEW "BrandManagersByBrand" AS
SELECT *
FROM BrandManagers
WHERE idBrandManager = (SELECT idBrandManager FROM brandBrandManager WHERE idBrand = (SELECT id FROM brand WHERE name='brandName'));



/* CLIENT */

CREATE VIEW "WishlistByClientId" AS
SELECT *
FROM product 
WHERE id = (SELECT id_product FROM productwishlist WHERE id_client ='clientId');


CREATE VIEW "PurchasesByClientId" AS
SELECT *
FROM purchase
WHERE id_client = 'clientId';


CREATE VIEW "ProductsInPurchase" AS
SELECT *
FROM purchaseproduct 
WHERE id_purchase = 'purchaseId';


CREATE VIEW "CartByClientId" AS
SELECT *
FROM cartproduct 
WHERE id_client = 'clientId';