/*
Trigger that prevents an admin from being banned
Test: INSERT INTO ban VALUES(1, 2, DEFAULT);
*/
DROP FUNCTION IF EXISTS ban_admin() CASCADE;
DROP TRIGGER IF EXISTS ban_admin ON ban CASCADE;
DROP FUNCTION IF EXISTS purchaseProduct_cost() CASCADE;
DROP TRIGGER IF EXISTS purchaseProduct_cost ON purchaseProduct CASCADE;

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


/*
Trigger that actualizes the of a product in a purchase according to its actual value
TEST: INSERT INTO purchase VALUES (2, 11, 1, DEFAULT, 'verificacao', 300, 'cartao credito', '5400 4102 4021 7362', 'Pedro Gonçalves', '2018-07-23', 235123482); 
INSERT INTO purchaseProduct VALUES (2, 4, 1, 1)
*/
CREATE FUNCTION purchaseProduct_cost() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE purchaseProduct
	SET cost = (SELECT price FROM PRODUCT WHERE id=NEW.id_product);
	RETURN NEW;
END	
$BODY$
LANGUAGE plpgsql;	

CREATE TRIGGER purchaseProduct_cost
	AFTER INSERT ON purchaseProduct
	FOR EACH ROW
		EXECUTE PROCEDURE purchaseProduct_cost();
		
/*CREATE FUNCTION purchase_cost() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE purchase
	SET Cost = SELECT 
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER purchase_cost
	AFTER INSERT ON purchase
	FOR EACH ROW
		EXECUTE PROCEDURE purchase_cost();*/