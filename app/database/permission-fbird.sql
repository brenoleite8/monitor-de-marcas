CREATE TABLE system_group (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100),
    uuid varchar(36));
INSERT INTO system_group (id, name) VALUES(1,'Admin');
INSERT INTO system_group (id, name) VALUES(2,'Standard');
INSERT INTO system_group (id, name) VALUES(3,'BChat Interno');
CREATE TABLE system_program (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100),
    controller varchar(100),
    actions blob sub_type 1);
INSERT INTO system_program (id, name, controller) VALUES(1,'System Group Form','SystemGroupForm');
INSERT INTO system_program (id, name, controller) VALUES(2,'System Group List','SystemGroupList');
INSERT INTO system_program (id, name, controller) VALUES(3,'System Program Form','SystemProgramForm');
INSERT INTO system_program (id, name, controller) VALUES(4,'System Program List','SystemProgramList');
INSERT INTO system_program (id, name, controller) VALUES(5,'System User Form','SystemUserForm');
INSERT INTO system_program (id, name, controller) VALUES(6,'System User List','SystemUserList');
INSERT INTO system_program (id, name, controller) VALUES(7,'Common Page','CommonPage');
INSERT INTO system_program (id, name, controller) VALUES(8,'System PHP Info','SystemPHPInfoView');
INSERT INTO system_program (id, name, controller) VALUES(9,'System ChangeLog View','SystemChangeLogView');
INSERT INTO system_program (id, name, controller) VALUES(10,'Welcome View','WelcomeView');
INSERT INTO system_program (id, name, controller) VALUES(11,'System Sql Log','SystemSqlLogList');
INSERT INTO system_program (id, name, controller) VALUES(12,'System Profile View','SystemProfileView');
INSERT INTO system_program (id, name, controller) VALUES(13,'System Profile Form','SystemProfileForm');
INSERT INTO system_program (id, name, controller) VALUES(14,'System SQL Panel','SystemSQLPanel');
INSERT INTO system_program (id, name, controller) VALUES(15,'System Access Log','SystemAccessLogList');
INSERT INTO system_program (id, name, controller) VALUES(16,'System Message Form','SystemMessageForm');
INSERT INTO system_program (id, name, controller) VALUES(17,'System Message List','SystemMessageList');
INSERT INTO system_program (id, name, controller) VALUES(18,'System Message Form View','SystemMessageFormView');
INSERT INTO system_program (id, name, controller) VALUES(19,'System Notification List','SystemNotificationList');
INSERT INTO system_program (id, name, controller) VALUES(20,'System Notification Form View','SystemNotificationFormView');
INSERT INTO system_program (id, name, controller) VALUES(21,'System Document Category List','SystemDocumentCategoryFormList');
INSERT INTO system_program (id, name, controller) VALUES(22,'System Document Form','SystemDocumentForm');
INSERT INTO system_program (id, name, controller) VALUES(23,'System Document Upload Form','SystemDocumentUploadForm');
INSERT INTO system_program (id, name, controller) VALUES(24,'System Document List','SystemDocumentList');
INSERT INTO system_program (id, name, controller) VALUES(25,'System Shared Document List','SystemSharedDocumentList');
INSERT INTO system_program (id, name, controller) VALUES(26,'System Unit Form','SystemUnitForm');
INSERT INTO system_program (id, name, controller) VALUES(27,'System Unit List','SystemUnitList');
INSERT INTO system_program (id, name, controller) VALUES(28,'System Access stats','SystemAccessLogStats');
INSERT INTO system_program (id, name, controller) VALUES(29,'System Preference form','SystemPreferenceForm');
INSERT INTO system_program (id, name, controller) VALUES(30,'System Support form','SystemSupportForm');
INSERT INTO system_program (id, name, controller) VALUES(31,'System PHP Error','SystemPHPErrorLogView');
INSERT INTO system_program (id, name, controller) VALUES(32,'System Database Browser','SystemDatabaseExplorer');
INSERT INTO system_program (id, name, controller) VALUES(33,'System Table List','SystemTableList');
INSERT INTO system_program (id, name, controller) VALUES(34,'System Data Browser','SystemDataBrowser');
INSERT INTO system_program (id, name, controller) VALUES(35,'System Menu Editor','SystemMenuEditor');
INSERT INTO system_program (id, name, controller) VALUES(36,'System Request Log','SystemRequestLogList');
INSERT INTO system_program (id, name, controller) VALUES(37,'System Request Log View','SystemRequestLogView');
INSERT INTO system_program (id, name, controller) VALUES(38,'System Administration Dashboard','SystemAdministrationDashboard');
INSERT INTO system_program (id, name, controller) VALUES(39,'System Log Dashboard','SystemLogDashboard');
INSERT INTO system_program (id, name, controller) VALUES(40,'System Session dump','SystemSessionDumpView');
INSERT INTO system_program (id, name, controller) VALUES(41,'System files diff','SystemFilesDiff');
INSERT INTO system_program (id, name, controller) VALUES(42,'System Information','SystemInformationView');
INSERT INTO system_program (id, name, controller) VALUES(43,'Form to add user to chat group','SystemAddUserGroupForm');
INSERT INTO system_program (id, name, controller) VALUES(44,'Form to start a chat','SystemNewChatForm');
INSERT INTO system_program (id, name, controller) VALUES(45,'Form to start a group chat','SystemNewChatGroupForm');
INSERT INTO system_program (id, name, controller) VALUES(46,'System monitor online users list','SystemUserMonitorHeaderList');
INSERT INTO system_program (id, name, controller) VALUES(47,'System Data Import','SystemDataImportForm');

CREATE TABLE system_unit (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100),
    connection_name varchar(100)
);
CREATE TABLE system_users (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100),
    login varchar(100),
    password varchar(100),
    email varchar(100),
    frontpage_id int, 
    system_unit_id int references system_unit(id), 
    active char(1),
    accepted_term_policy char(1),
    accepted_term_policy_at varchar(100),
    two_factor_enabled char(1),
    two_factor_type varchar(100),
    two_factor_secret varchar(255),
    FOREIGN KEY(frontpage_id) REFERENCES system_program(id));
INSERT INTO system_users VALUES(1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin@admin.net',10,NULL,'Y', NULL, NULL, 'N', NULL, NULL);
INSERT INTO system_users VALUES(2,'User','user','ee11cbb19052e40b07aac0ca060c23ee','user@user.net',7,NULL,'Y', NULL, NULL, 'N', NULL, NULL);
CREATE TABLE system_user_group (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_group_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_users(id),
    FOREIGN KEY(system_group_id) REFERENCES system_group(id));
INSERT INTO system_user_group VALUES(1,1,1);
INSERT INTO system_user_group VALUES(2,2,2);
INSERT INTO system_user_group VALUES(3,1,2);
INSERT INTO system_user_group (id, system_user_id, system_group_id) VALUES (4,1,3);
CREATE TABLE system_group_program (
    id INTEGER PRIMARY KEY NOT NULL,
    system_group_id int,
    system_program_id int,
    actions blob sub_type 1,
    FOREIGN KEY(system_group_id) REFERENCES system_group(id),
    FOREIGN KEY(system_program_id) REFERENCES system_program(id));
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(1,1,1);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(2,1,2);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(3,1,3);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(4,1,4);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(5,1,5);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(6,1,6);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(7,1,8);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(8,1,9);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(9,1,11);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(10,1,14);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(11,1,15);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(12,2,10);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(13,2,12);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(14,2,13);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(15,2,16);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(16,2,17);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(17,2,18);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(18,2,19);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(19,2,20);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(20,1,21);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(21,2,22);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(22,2,23);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(23,2,24);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(24,2,25);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(25,1,26);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(26,1,27);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(27,1,28);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(28,1,29);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(29,2,30);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(30,1,31);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(31,1,32);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(32,1,33);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(33,1,34);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(34,1,35);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(36,1,36);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(37,1,37);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(38,1,38);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(39,1,39);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(40,1,40);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (41,1,41);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (42,1,42);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(43,1,46);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(44,1,47);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(45,3,43);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(46,3,44);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES(47,3,45);
CREATE TABLE system_user_program (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_program_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_users(id),
    FOREIGN KEY(system_program_id) REFERENCES system_program(id));
INSERT INTO system_user_program VALUES(1,2,7);
CREATE TABLE system_preference (
    id blob sub_type 1,
    preference blob sub_type 1
);
CREATE TABLE system_user_unit (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_unit_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_users(id),
    FOREIGN KEY(system_unit_id) REFERENCES system_unit(id));

CREATE INDEX sys_user_program_idx ON system_users(frontpage_id);
CREATE INDEX sys_user_group_group_idx ON system_user_group(system_group_id);
CREATE INDEX sys_user_group_user_idx ON system_user_group(system_user_id);
CREATE INDEX sys_group_program_program_idx ON system_group_program(system_program_id);
CREATE INDEX sys_group_program_group_idx ON system_group_program(system_group_id);
CREATE INDEX sys_user_program_program_idx ON system_user_program(system_program_id);
CREATE INDEX sys_user_program_user_idx ON system_user_program(system_user_id);
