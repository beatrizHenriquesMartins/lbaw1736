--CREATE INDEX idx_users ON users USING hash (id); /*cardinalidade alta-nao se faz cluster*/

CREATE INDEX idx_message ON messages USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_product ON products USING hash (name); /*cardinalidade media-bom candidato para cluster*/

--CREATE INDEX idx_productwishlist ON productwishlist USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

--CREATE INDEX idx_cartproduct ON cartproduct USING hash (id_client); /*cardinalidade media-bom candidato para cluster*/

CREATE INDEX idx_purchase ON purchases USING btree (id_client); /*cardinalidade media-bom candidato para cluster*/

--CREATE INDEX idx_purchaseproduct ON purchaseproduct USING hash (id_purchase); /*cardinalidade media-nao se faz cluster*/

--CREATE INDEX idx_productreview ON productreview USING hash (id_product); /*cardinalidade media-bom candidato para cluster*/

--CREATE INDEX searchcategory_idx ON categories USING GIST (to_tsvector('english', categoryName));

CREATE INDEX searchbigdescription_idx ON products USING GIST (to_tsvector('english', bigDescription));

CREATE INDEX searchshortdescription_idx ON products USING GIST (to_tsvector('english', shortDescription));
