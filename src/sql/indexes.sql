--CREATE INDEX idx_users ON users USING hash (id); /*cardinalidade alta-nao se faz cluster*/

CREATE INDEX idx_message ON message USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_product ON product USING hash (name); /*cardinalidade media-bom candidato para cluster*/

--CREATE INDEX idx_productwishlist ON productwishlist USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

--CREATE INDEX idx_cartproduct ON cartproduct USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_purchase ON purchase USING btree (id_client); /*cardinalidade media-bom candidato para cluster*/

--CREATE INDEX idx_purchaseproduct ON purchaseproduct USING hash (id_purchase); /*cardinalidade media-nao se faz cluster*/

--CREATE INDEX idx_productreview ON productreview USING hash (id_product); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX search_idx ON productcategory USING GIST (to_tsvector('english', categoryName));