CREATE DEFINER = CURRENT_USER TRIGGER tg_places_AFTER_UPDATE AFTER UPDATE ON tb_places FOR EACH ROW
BEGIN
	CALL sp_placesdata_save(NEW.idplace);
END