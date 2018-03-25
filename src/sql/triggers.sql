
--Trigger that prevents an admin from being banned
--Test: INSERT INTO ban VALUES(1, 2, DEFAULT);

DROP FUNCTION IF EXISTS ban_admin() CASCADE;
DROP TRIGGER IF EXISTS ban_admin ON ban CASCADE;
DROP FUNCTION IF EXISTS purchaseProduct_cost() CASCADE;
DROP TRIGGER IF EXISTS purchaseProduct_cost ON purchaseProduct CASCADE;
DROP FUNCTION IF EXISTS purchase_cost() CASCADE;
DROP TRIGGER IF EXISTS purchase_cost ON purchase CASCADE;

CREATE FUNCTION ban_admin() RETURNS TRIGGER AS
$BODY$
BEGIN
	IF EXISTS (SELECT * FROM admin WHERE NEW.id_user = admin.id) THEN
		RAISE EXCEPTION 'An Admin can not be banned';
	END IF;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER ban_admin
	BEFORE INSERT OR UPDATE ON ban
	FOR EACH ROW
		EXECUTE PROCEDURE ban_admin();





CREATE FUNCTION purchaseProduct_cost() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE purchaseProduct
	SET cost = (SELECT (SELECT price FROM PRODUCT WHERE id=NEW.id_product));
	RETURN NEW;
END	
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER purchase_cost
	AFTER INSERT ON purchaseProduct
	FOR EACH ROW
		EXECUTE PROCEDURE purchase_cost();	
		

CREATE FUNCTION purchase_cost() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE purchaseProduct
	SET cost = (SELECT (SELECT price FROM PRODUCT WHERE id=NEW.id_product));
	UPDATE purchase
	SET cost = (SELECT SUM(cost2) FROM (SELECT purchaseProduct.cost AS cost2 FROM purchaseProduct WHERE ( purchaseProduct.id_purchase = NEW.id_purchase) ) AS derived_table);
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;	



--Trigger that actualizes the of a product in a purchase according to its actual value
--TEST: 
--INSERT INTO purchase VALUES (11, 11, 1, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482); 
--INSERT INTO purchaseProduct VALUES (11, 4, 1, 1)		
		
