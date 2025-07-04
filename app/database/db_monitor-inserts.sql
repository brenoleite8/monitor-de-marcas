INSERT INTO system_group (id,name,uuid) VALUES (1,'Admin',''); 

INSERT INTO system_group (id,name,uuid) VALUES (2,'Usuário',''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (1,1,1,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (2,1,2,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (3,1,3,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (4,1,4,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (5,1,5,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (6,1,6,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (7,1,8,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (8,1,9,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (9,1,11,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (10,1,14,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (11,1,15,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (12,2,10,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (13,2,12,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (14,2,13,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (15,2,19,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (16,2,20,''); 

INSERT INTO system_group_program (id,system_group_id,system_program_id,actions) VALUES (17,2,30,''); 

INSERT INTO system_program (id,name,controller,actions) VALUES (1,'System Group Form','SystemGroupForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (2,'System Group List','SystemGroupList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (3,'System Program Form','SystemProgramForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (4,'System Program List','SystemProgramList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (5,'System User Form','SystemUserForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (6,'System User List','SystemUserList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (7,'Common Page','CommonPage',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (8,'System PHP Info','SystemPHPInfoView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (9,'System ChangeLog View','SystemChangeLogView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (10,'Welcome View','WelcomeView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (11,'System Sql Log','SystemSqlLogList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (12,'System Profile View','SystemProfileView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (13,'System Profile Form','SystemProfileForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (14,'System SQL Panel','SystemSQLPanel',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (15,'System Access Log','SystemAccessLogList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (16,'System Message Form','SystemMessageForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (17,'System Message List','SystemMessageList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (18,'System Message Form View','SystemMessageFormView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (19,'System Notification List','SystemNotificationList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (20,'System Notification Form View','SystemNotificationFormView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (21,'System Document Category List','SystemDocumentCategoryFormList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (22,'System Document Form','SystemDocumentForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (23,'System Document Upload Form','SystemDocumentUploadForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (24,'System Document List','SystemDocumentList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (25,'System Shared Document List','SystemSharedDocumentList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (26,'System Unit Form','SystemUnitForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (27,'System Unit List','SystemUnitList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (28,'System Access stats','SystemAccessLogStats',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (29,'System Preference form','SystemPreferenceForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (30,'System Support form','SystemSupportForm',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (31,'System PHP Error','SystemPHPErrorLogView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (32,'System Database Browser','SystemDatabaseExplorer',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (33,'System Table List','SystemTableList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (34,'System Data Browser','SystemDataBrowser',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (35,'System Menu Editor','SystemMenuEditor',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (36,'System Request Log','SystemRequestLogList',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (37,'System Request Log View','SystemRequestLogView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (38,'System Administration Dashboard','SystemAdministrationDashboard',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (39,'System Log Dashboard','SystemLogDashboard',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (40,'System Session dump','SystemSessionDumpView',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (41,'Files diff','SystemFilesDiff',null); 

INSERT INTO system_program (id,name,controller,actions) VALUES (42,'System Information','SystemInformationView',null); 

INSERT INTO system_unit (id,name,connection_name) VALUES (1,'Matriz','matriz'); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (1,1,1); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (2,2,2); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (3,1,2); 

INSERT INTO system_user_program (id,system_user_id,system_program_id) VALUES (1,2,7); 

INSERT INTO system_users (id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy,two_factor_enabled,two_factor_type,two_factor_secret) VALUES (1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin@admin.net',10,null,'Y','','',null,null,null); 

INSERT INTO system_users (id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy,two_factor_enabled,two_factor_type,two_factor_secret) VALUES (2,'User','user','ee11cbb19052e40b07aac0ca060c23ee','user@user.net',7,null,'Y','','',null,null,null); 

INSERT INTO system_user_unit (id,system_user_id,system_unit_id) VALUES (1,1,1); 
