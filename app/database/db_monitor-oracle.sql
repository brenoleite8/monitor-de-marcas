CREATE TABLE system_document( 
      id number(10)    NOT NULL , 
      category_id number(10)    NOT NULL , 
      system_user_id number(10)   , 
      title varchar(3000)    NOT NULL , 
      description varchar(3000)   , 
      submission_date date   , 
      archive_date date   , 
      filename varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_category( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_group( 
      id number(10)    NOT NULL , 
      document_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_user( 
      id number(10)    NOT NULL , 
      document_id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
      actions varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_message( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_user_to_id number(10)    NOT NULL , 
      subject varchar(3000)    NOT NULL , 
      message varchar(3000)   , 
      dt_message timestamp(0)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_notification( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_user_to_id number(10)    NOT NULL , 
      subject varchar(3000)   , 
      message varchar(3000)   , 
      dt_message timestamp(0)   , 
      action_url varchar(3000)   , 
      action_label varchar(3000)   , 
      icon varchar(3000)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      controller varchar(3000)    NOT NULL , 
      actions varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      connection_name varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      login varchar(3000)    NOT NULL , 
      password varchar(3000)    NOT NULL , 
      email varchar(3000)   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
      accepted_term_policy_at varchar(3000)   , 
      accepted_term_policy char  (1)   , 
      two_factor_enabled char  (1)    DEFAULT 'N' , 
      two_factor_type varchar  (100)   , 
      two_factor_secret varchar  (255)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_materiais_estudo( 
      id number(10)    NOT NULL , 
      titulo varchar(3000)    NOT NULL , 
      palavras_chave varchar(3000)    NOT NULL , 
      link_video varchar(3000)   , 
      link_site varchar(3000)   , 
      imagem varchar(3000)   , 
      conteudo varchar(3000)    NOT NULL , 
      system_user_id_create number(10)    NOT NULL , 
      system_user_id_update number(10)   , 
      system_unit_id number(10)    NOT NULL , 
      created_at timestamp(0)    NOT NULL , 
      updated_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_processo( 
      id number(10)    NOT NULL , 
      num_protocolo varchar  (50)    NOT NULL , 
      data_ultimo_evento date   , 
      comprovante_file_name varchar(3000)   , 
      comprovante_content varchar(3000)   , 
      system_unit_id number(10)    NOT NULL , 
      system_user_id_create number(10)    NOT NULL , 
      system_user_id_update number(10)   , 
      created_at timestamp(0)    NOT NULL , 
      updated_at timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tb_processo_evento( 
      id number(10)    NOT NULL , 
      tb_processo_id number(10)    NOT NULL , 
      num_revista varchar  (15)    NOT NULL , 
      data_evento date    NOT NULL , 
      texto_evento varchar(3000)    NOT NULL , 
      notificado_sn varchar  (1)   , 
      system_unit_id number(10)    NOT NULL , 
      created_at timestamp(0)    NOT NULL , 
      updated_at timestamp(0)   , 
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
 CREATE SEQUENCE tb_materiais_estudo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tb_materiais_estudo_id_seq_tr 

BEFORE INSERT ON tb_materiais_estudo FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tb_materiais_estudo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tb_processo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tb_processo_id_seq_tr 

BEFORE INSERT ON tb_processo FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tb_processo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tb_processo_evento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tb_processo_evento_id_seq_tr 

BEFORE INSERT ON tb_processo_evento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tb_processo_evento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 