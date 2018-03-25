CREATE INDEX idx_purchase ON purchase(id_client)

CREATE INDEX idx_brand ON brand(name)

CREATE INDEX idx_users ON users(id);

CREATE INDEX idx_message ON message(id_client, id_chatSupport);

CREATE INDEX idx_product ON product(id_category, id_brand);


/*
sao todos do tipo b-tree (o por defeito)
É preciso ver individualmente se aumentam a velocidade da pesquisa ou nao.
Pode-se usar o comando analyse
ex: analyze	verbose	productcategory;
*/
