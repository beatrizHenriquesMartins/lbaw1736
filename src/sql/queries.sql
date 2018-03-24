/*os comentário sao com estas barras ou com estas*/

/*SEARCH
-lista de todos os produtos*/

/*Tens de fazer create view com o nome da vista
que represente aquilo que estas a fazer na query
Nao podes ter duas variaveis com o mesmo nome
mesmo que sejam de tabelas diferentes
Por último nesta query não fazia o JOIN
e fazia da maneira como está agora*/
CREATE VIEW "ListProducts" AS
SELECT *
FROM product;

****************SEARCHbyCategory
-lista de todos os produtos
CREATE VIEW "ListProductsByCategory" AS
SELECT *
FROM product
WHERE id_category = (SELECT id FROM productcategory WHERE categoryName = 'Fashion');

**************VIEW PRODUCT
-info de 1 produto
SELECT product.name, product.quantityInStock, brand.name, productCategory.categoryName
FROM product
INNER JOIN productCategory ON (productCategory.id=product.id_category)
INNER JOIN productReview ON (productReview.id_product = product.id)
INNER JOIN brand ON (brand.id = product.id_brand);

*************REGISTER
-lista de todos ultilizadores (email,username)
SELECT users.email, users.username
FROM users;

***************LOGIN
-lista de todos ultilizadores (email,username)
-utilizador em particular (password)

***************APPLY SUPPORT
-lista supports
SELECT users.email, users.username
FROM users
INNER JOIN chatSupport ON (chatSupport.id = users.id);


****************APPLY BRANDMANAGER
-lista brand manager
SELECT users.email, users.username
FROM users
INNER JOIN brandBrandManager ON (brandBrandManager.idbrandManager = users.id);

*********VIEW PROFILE (client)
SELECT users.email, users.username, users.firstName, users.lastName, users.imageURL
FROM users
INNER JOIN brandBrandManager ON (brandBrandManager.idbrandManager = users.id);

************VIEW WISHLIST
SELECT product.name, product.modelNumber, product.price
FROM product
INNER JOIN productwishlist ON (productwishlist.id_product = product.id)
INNER JOIN wishlist ON (wishlist.id = productwishlist.id_wishlist)
INNER JOIN client ON (client.id = productwishlist.id_wishlist);

****************PURCHASE LIST
SELECT product.name, product.modelNumber, purchaseproduct.cost, purchaseproduct.quantity, purchase.purchaseDate, purchase.purchaseState
FROM product
INNER JOIN purchaseproduct ON (purchaseproduct.id_product = product.id)
INNER JOIN purchase ON (purchase.id = purchaseproduct.id_purchase)
INNER JOIN client ON (client.id = purchase.id_client);

**************VIEW CART
SELECT product.name, product.modelNumber, product.price
FROM product
INNER JOIN cartProduct ON (cartProduct.id_product = product.id)
INNER JOIN cart ON (cart.id = cartProduct.id_cart)
INNER JOIN client ON (client.id_cart = cart.id);
