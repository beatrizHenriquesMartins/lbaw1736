/*Trigger that prevents an admin from being banned*/
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
	BEFORE INSERT ON ban
	FOR EACH ROW
		EXECUTE PROCEDURE ban_admin();

/*
client -> cart NN
corrigir isto sempre
eliminar o cart e as wishlist
eliminar chat
dependencias funcionais no productReview
justificação da forma Normal do esquema
link para github
criar domínios
*/		