CREATE PROCEDURE sp_permissao_save(
pidpermissao INT,
pdespermissao VARCHAR(64)
)
BEGIN

    IF pidpermissao = 0 THEN
    
        INSERT INTO tb_permissoes (despermissao)
        VALUES(pdespermissao);
        
        SET pidpermissao = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_permissoes
        SET 
            despermissao = pdespermissao
        WHERE idpermissao = pidpermissao;

    END IF;

    CALL sp_permissao_get(pidpermissao);

END