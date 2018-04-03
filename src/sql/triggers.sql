DROP FUNCTION IF EXISTS ban_admin() CASCADE;
DROP TRIGGER IF EXISTS ban_admin ON ban CASCADE;

DROP FUNCTION IF EXISTS purchase_cost() CASCADE;
DROP TRIGGER IF EXISTS purchase_cost ON purchase CASCADE;

--Trigger that prevents an admin from being banned
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

--Trigger that actualizes the of a product in a purchase according to its actual value
CREATE TRIGGER ban_admin
	BEFORE INSERT OR UPDATE ON ban
	FOR EACH ROW
		EXECUTE PROCEDURE ban_admin();



CREATE FUNCTION purchase_cost() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE purchaseProduct
	SET cost = (SELECT (SELECT price FROM product WHERE id=NEW.id_product) * NEW.quantity) WHERE purchaseProduct.id_product = NEW.id_product AND purchaseProduct.id_purchase = NEW.id_purchase;
	UPDATE purchase
	SET cost = (SELECT SUM(cost2) FROM (SELECT purchaseProduct.cost AS cost2 FROM purchaseProduct WHERE ( purchaseProduct.id_purchase = NEW.id_purchase) ) AS derived_table) WHERE purchase.id = NEW.id_purchase;
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;	



CREATE TRIGGER purchase_cost
	AFTER INSERT ON purchaseProduct
	FOR EACH ROW
		EXECUTE PROCEDURE purchase_cost();	
		





