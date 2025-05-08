CREATE TABLE system_document( 
      id int   NOT NULL  , 
      category_id int   NOT NULL  , 
      system_user_id int   , 
      title nvarchar(max)   NOT NULL  , 
      description nvarchar(max)   , 
      submission_date date   , 
      archive_date date   , 
      filename nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_category( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_group( 
      id int   NOT NULL  , 
      document_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_user( 
      id int   NOT NULL  , 
      document_id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
      actions nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_message( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_user_to_id int   NOT NULL  , 
      subject nvarchar(max)   NOT NULL  , 
      message nvarchar(max)   , 
      dt_message datetime2   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_notification( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_user_to_id int   NOT NULL  , 
      subject nvarchar(max)   , 
      message nvarchar(max)   , 
      dt_message datetime2   , 
      action_url nvarchar(max)   , 
      action_label nvarchar(max)   , 
      icon nvarchar(max)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      controller nvarchar(max)   NOT NULL  , 
      actions nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      connection_name nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      login nvarchar(max)   NOT NULL  , 
      password nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at nvarchar(max)   , 
      accepted_term_policy char  (1)   , 
      two_factor_enabled char  (1)     DEFAULT 'N', 
      two_factor_type varchar  (100)   , 
      two_factor_secret varchar  (255)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_materiais_estudo( 
      id  INT IDENTITY    NOT NULL  , 
      titulo nvarchar(max)   NOT NULL  , 
      palavras_chave nvarchar(max)   NOT NULL  , 
      link_video nvarchar(max)   , 
      link_site nvarchar(max)   , 
      imagem nvarchar(max)   , 
      conteudo nvarchar(max)   NOT NULL  , 
      system_user_id_create int   NOT NULL  , 
      system_user_id_update int   , 
      system_unit_id int   NOT NULL  , 
      created_at datetime2   NOT NULL  , 
      updated_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_processo( 
      id  INT IDENTITY    NOT NULL  , 
      num_protocolo varchar  (50)   NOT NULL  , 
      data_ultimo_evento date   , 
      system_unit_id int   NOT NULL  , 
      system_user_id_create int   NOT NULL  , 
      system_user_id_update int   , 
      created_at datetime2   NOT NULL  , 
      updated_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_processo_evento( 
      id  INT IDENTITY    NOT NULL  , 
      tb_processo_id int   NOT NULL  , 
      num_revista varchar  (15)   NOT NULL  , 
      data_evento date   NOT NULL  , 
      texto_evento nvarchar(max)   NOT NULL  , 
      notificado_sn varchar  (1)   , 
      system_unit_id int   NOT NULL  , 
      created_at datetime2   NOT NULL  , 
      updated_at datetime2   , 
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
