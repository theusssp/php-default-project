CREATE DEFINER = CURRENT_USER TRIGGER tg_events_BEFORE_DELETE BEFORE DELETE ON tb_events FOR EACH ROW
BEGIN
	CALL sp_eventsdata_remove(OLD.idevent);
END