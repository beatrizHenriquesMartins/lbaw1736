/* em vez do id */
CREATE INDEX idx_productcategory ON productcategory(categoryName);

CREATE INDEX idx_productreview ON productreview(id_product, id_purchase);

/* em vez do id */
CREATE INDEX idx_brand ON brand(name);

CREATE INDEX idx_productwishlist ON productwishlist(id_client, id_product);

CREATE INDEX idx_cartproduct ON cartproduct(id_client, id_product);

/*
sao todos do tipo b-tree (o por defeito)
É preciso ver individualmente se aumentam a velocidade da pesquisa ou nao.
Pode-se usar o comando analyse
ex: analyze	verbose	productcategory;
*/