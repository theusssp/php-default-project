CREATE DEFINER = CURRENT_USER TRIGGER tg_eventscalendars_AFTER_UPDATE AFTER UPDATE ON tb_eventscalendars FOR EACH ROW
BEGIN
	CALL sp_eventsdata_save(NEW.idevent);
END