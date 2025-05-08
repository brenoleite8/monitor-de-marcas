CREATE TABLE system_document( 
      id integer   NOT NULL  , 
      category_id integer   NOT NULL  , 
      system_user_id integer   , 
      title text   NOT NULL  , 
      description text   , 
      submission_date date   , 
      archive_date date   , 
      filename text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_category( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_group( 
      id integer   NOT NULL  , 
      document_id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_user( 
      id integer   NOT NULL  , 
      document_id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
      actions text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_message( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_user_to_id integer   NOT NULL  , 
      subject text   NOT NULL  , 
      message text   , 
      dt_message timestamp   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_notification( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_user_to_id integer   NOT NULL  , 
      subject text   , 
      message text   , 
      dt_message timestamp   , 
      action_url text   , 
      action_label text   , 
      icon text   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
      actions text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_group_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_program_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id integer   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id integer   , 
      system_unit_id integer   , 
      active char  (1)   , 
      accepted_term_policy_at text   , 
      accepted_term_policy char  (1)   , 
      two_factor_enabled char  (1)     DEFAULT 'N', 
      two_factor_type varchar  (100)   , 
      two_factor_secret varchar  (255)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_materiais_estudo( 
      id  SERIAL    NOT NULL  , 
      titulo text   NOT NULL  , 
      palavras_chave text   NOT NULL  , 
      link_video text   , 
      link_site text   , 
      imagem text   , 
      conteudo text   NOT NULL  , 
      system_user_id_create integer   NOT NULL  , 
      system_user_id_update integer   , 
      system_unit_id integer   NOT NULL  , 
      created_at timestamp   NOT NULL  , 
      updated_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_processo( 
      id  SERIAL    NOT NULL  , 
      num_protocolo varchar  (50)   NOT NULL  , 
      data_ultimo_evento date   , 
      system_unit_id integer   NOT NULL  , 
      system_user_id_create integer   NOT NULL  , 
      system_user_id_update integer   , 
      created_at timestamp   NOT NULL  , 
      updated_at timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_processo_evento( 
      id  SERIAL    NOT NULL  , 
      tb_processo_id integer   NOT NULL  , 
      num_revista varchar  (15)   NOT NULL  , 
      data_evento date   NOT NULL  , 
      texto_evento text   NOT NULL  , 
      notificado_sn varchar  (1)   , 
      system_unit_id integer   NOT NULL  , 
      created_at timestamp   NOT NULL  , 
      updated_at timestamp   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE system_document ADD CONSTRAINT fk_system_document_2 FOREIGN KEY (category_id) references system_document_category(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE tb_materiais_estudo ADD CONSTRAINT fk_tb_materiais_estudo_1 FOREIGN KEY (system_user_id_create) references system_users(id); 
ALTER TABLE tb_materiais_estudo ADD CONSTRAINT fk_tb_materiais_estudo_2 FOREIGN KEY (system_user_id_update) references system_users(id); 
ALTER TABLE tb_materiais_estudo ADD CONSTRAINT fk_tb_materiais_estudo_3 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE tb_processo ADD CONSTRAINT fk_tb_processo_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE tb_processo ADD CONSTRAINT fk_tb_processo_2 FOREIGN KEY (system_user_id_create) references system_users(id); 
ALTER TABLE tb_processo ADD CONSTRAINT fk_tb_processo_3 FOREIGN KEY (system_user_id_update) references system_users(id); 
ALTER TABLE tb_processo_evento ADD CONSTRAINT fk_tb_processo_evento_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE tb_processo_evento ADD CONSTRAINT fk_tb_processo_evento_2 FOREIGN KEY (tb_processo_id) references tb_processo(id); 
 
 CREATE index idx_system_document_category_id on system_document(category_id); 
CREATE index idx_system_document_system_user_id on system_document(system_user_id); 
CREATE index idx_system_document_group_document_id on system_document_group(document_id); 
CREATE index idx_system_document_group_system_group_id on system_document_group(system_group_id); 
CREATE index idx_system_document_user_document_id on system_document_user(document_id); 
CREATE index idx_system_document_user_system_user_id on system_document_user(system_user_id); 
CREATE index idx_system_group_program_system_program_id on system_group_program(system_program_id); 
CREATE index idx_system_group_program_system_group_id on system_group_program(system_group_id); 
CREATE index idx_system_message_system_user_id on system_message(system_user_id); 
CREATE index idx_system_message_system_user_to_id on system_message(system_user_to_id); 
CREATE index idx_system_notification_system_user_id on system_notification(system_user_id); 
CREATE index idx_system_notification_system_user_to_id on system_notification(system_user_to_id); 
CREATE index idx_system_user_group_system_group_id on system_user_group(system_group_id); 
CREATE index idx_system_user_group_system_user_id on system_user_group(system_user_id); 
CREATE index idx_system_user_program_system_program_id on system_user_program(system_program_id); 
CREATE index idx_system_user_program_system_user_id on system_user_program(system_user_id); 
CREATE index idx_system_users_system_unit_id on system_users(system_unit_id); 
CREATE index idx_system_users_frontpage_id on system_users(frontpage_id); 
CREATE index idx_system_user_unit_system_user_id on system_user_unit(system_user_id); 
CREATE index idx_system_user_unit_system_unit_id on system_user_unit(system_unit_id); 
CREATE index idx_tb_materiais_estudo_system_user_id_create on tb_materiais_estudo(system_user_id_create); 
CREATE index idx_tb_materiais_estudo_system_user_id_update on tb_materiais_estudo(system_user_id_update); 
CREATE index idx_tb_materiais_estudo_system_unit_id on tb_materiais_estudo(system_unit_id); 
CREATE index idx_tb_processo_system_unit_id on tb_processo(system_unit_id); 
CREATE index idx_tb_processo_system_user_id_create on tb_processo(system_user_id_create); 
CREATE index idx_tb_processo_system_user_id_update on tb_processo(system_user_id_update); 
CREATE index idx_tb_processo_evento_system_unit_id on tb_processo_evento(system_unit_id); 
CREATE index idx_tb_processo_evento_tb_processo_id on tb_processo_evento(tb_processo_id); 
