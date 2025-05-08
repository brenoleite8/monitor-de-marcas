SELECT setval('tb_materiais_estudo_id_seq', coalesce(max(id),0) + 1, false) FROM tb_materiais_estudo;
SELECT setval('tb_processo_id_seq', coalesce(max(id),0) + 1, false) FROM tb_processo;
SELECT setval('tb_processo_evento_id_seq', coalesce(max(id),0) + 1, false) FROM tb_processo_evento;