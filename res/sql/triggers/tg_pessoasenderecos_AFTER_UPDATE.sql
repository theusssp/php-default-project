CREATE DEFINER = CURRENT_USER TRIGGER tg_pessoasenderecos_AFTER_UPDATE AFTER UPDATE ON tb_pessoasenderecos FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_save(NEW.idpessoa);
END