CREATE DEFINER = CURRENT_USER TRIGGER tb_usuarios_AFTER_INSERT AFTER INSERT ON tb_usuarios FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_save(NEW.idpessoa);
END