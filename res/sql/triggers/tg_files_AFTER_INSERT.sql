CREATE DEFINER = CURRENT_USER TRIGGER tg_files_AFTER_INSERT AFTER INSERT ON tb_files FOR EACH ROW
BEGIN
	CALL sp_filestrigger_save(NEW.idfile);
END