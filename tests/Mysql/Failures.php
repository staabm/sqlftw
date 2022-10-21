<?php declare(strict_types = 1);

// spell-check-ignore: DBACCESS TABLENAME abc abcdefghijklmnopqrstuvwxyz condname1 ctx dat dblwr ddse endswithspace fil haha hehe hoho lsn pri testrole testuser wp xyzzy

namespace SqlFtw\Tests\Mysql;

trait Failures
{

    /** @var string[] */
    private static $sometimeFailures = [
        "SET GLOBAL replica_parallel_type=@save_replica_parallel_type;",
        "SET GLOBAL replica_parallel_type= @save_replica_parallel_type;",
        "SET GLOBAL replica_parallel_workers=@save_replica_parallel_workers;",
        "SET GLOBAL replica_parallel_workers= @save_replica_parallel_workers;",
        "SET GLOBAL replica_preserve_commit_order=@save_replica_preserve_commit_order;",
        "SET GLOBAL replica_preserve_commit_order= @save_replica_preserve_commit_order;",
        "SET GLOBAL binlog_transaction_dependency_tracking=@save_binlog_transaction_dependency_tracking;",
        "SET @@global.dragnet.log_error_filter_rules= @rules;",
    ];

    /** @var string[] */
    private static $knownFailures = [
        // encoding
        "DROP TABLE IF EXISTS `abc\xFFdef`;",
        "CREATE TABLE `abc\xFFdef` (i int);",
        "INSERT INTO `abc\xFFdef` VALUES (1);",
        "INSERT INTO abc\xFFdef VALUES (2);",
        "SELECT * FROM `abc\xFFdef`;",
        "SELECT * FROM abc\xFFdef;",
        "DROP TABLE `abc\xFFdef`;",

        // persist vs DEFAULT
        "SET PERSIST_ONLY innodb_data_file_path = DEFAULT;",
        "SET PERSIST_ONLY pid_file = DEFAULT;",

        // qualified column name
        'create table t1 (t1.index int)',
        'create table t1(t1.name int)',
        'create table t2(test.t2.name int)',
        // "REVOKE <role>" has no "ON"
        'REVOKE system_user_role ON *.* FROM non_sys_user',
        // index without a name
        'create index on edges (s)',
        'create index on edges (e)',
        'CREATE INDEX ON t1(a)',
        'CREATE INDEX ON t1 (col1, col2)',
        // pseudo-replica mode trickery
        "SET @@session.sql_mode=1436549152;",
        // error ignored...
        "-- error ER_BAD_FIELD_ERROR\nSET @@character_set_connection = utf8 + latin2;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@character_set_client = utf8 + latin2;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@character_set_database = utf8 + latin2;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@character_set_filesystem = utf8 + latin2;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@character_set_results = utf8 + latin2;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@character_set_server = utf8 + latin2;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@collation_connection = latin7_general_ci + latin7_general_cs;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@collation_database = latin7_general_ci + latin7_general_cs;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@collation_server = latin7_general_ci + latin7_general_cs;",
        "-- error ER_BAD_FIELD_ERROR\nSET @@lc_time_names = en_US | en_GB ;",
        // collides with ignored "ER_INVALID_DEFAULT"
        "-- error ER_INVALID_DEFAULT_UTF8MB4_COLLATION\nSET @@default_collation_for_utf8mb4 = latin2_general_ci;",
        // depends on "SELECT ... INTO @space_id;"
        "set global innodb_fil_make_page_dirty_debug = @space_id;",
        "SET SESSION innodb_interpreter = CONCAT('find_fil_page_lsn ', @space_id, ' 0');",
        "SET SESSION innodb_interpreter = @cmd;",
        "SET SESSION innodb_interpreter = CONCAT('dblwr_force_crash ', @space_id, ' 0');",
        "-- error 2013\nSET SESSION innodb_interpreter = CONCAT('make_page_dirty ', @space_id, ' 0');",
        "SET global innodb_fil_make_page_dirty_debug=@space_id;",
        "-- error CR_SERVER_LOST\nSET GLOBAL innodb_fil_make_page_dirty_debug = @space_id;",
        // 63bit limit
        "set global flush_time=cast(-1 as unsigned int);",
        "set max_join_size=cast(-1 as unsigned int);",
        "set global sync_relay_log=cast(-1 as unsigned int);",
        "set global sync_relay_log_info=cast(-1 as unsigned int);",
        "set global sync_source_info=cast(-1 as unsigned int);",
        "set global thread_cache_size=cast(-1 as unsigned int);",
        // session var should be returned when global does not exist
        "SELECT @@global.rbr_exec_mode;",
        // "table name not allowed here"
        "-- error ER_TABLENAME_NOT_ALLOWED_HERE\n(SELECT a FROM t1 LIMIT 1) ORDER BY t1.a;",
        "-- error ER_TABLENAME_NOT_ALLOWED_HERE\n((SELECT a FROM t1 LIMIT 1)) ORDER BY t1.a;",
        "-- error ER_TABLENAME_NOT_ALLOWED_HERE\n(SELECT a FROM t1 LIMIT 1) UNION ALL (SELECT 2) ORDER BY t1.b;",
        "-- error ER_TABLENAME_NOT_ALLOWED_HERE\n(SELECT a FROM t1 LIMIT 1) UNION ALL ((SELECT 2)) ORDER BY t1.b;",
        "-- error ER_TABLENAME_NOT_ALLOWED_HERE\n(SELECT a FROM t1 LIMIT 1) UNION ALL (SELECT a FROM t1 ORDER BY a LIMIT 2)\n  ORDER BY t1.b;",
        // "rows" is already a reserved word
        "--echo the result rows with missed equal to NULL should count all rows (160000)\n--echo the other rows are the failed lookups and there should not be any such\nselect if(isnull(t1.a),t2.a,NULL) missed, count(*) rows from t2 left join t1 on t1.a=t2.a group by if(isnull(t1.a),t2.a,NULL)",
        "--echo the left join below should result in scanning t2 and do pk lookups in t1\n--replace_column 10 # 11 #\nexplain select if(isnull(t1.a),t2.a,NULL) missed, count(*) rows from t2 left join t1 on t1.a=t2.a group by if(isnull(t1.a),t2.a,NULL)",
        "-- error ER_NO_SYSTEM_TABLE_ACCESS\n  CREATE PROCEDURE ddse_access() DROP TABLE mysql.innodb_index_stats(i INTEGER);",
        // behavior differs in plain sql and in procedure
        "create event e22830_1 on schedule every 1 hour do\nbegin\n  call p22830_wait();\n  alter event e22830_1 on schedule every (select 8 from dual) hour;\nend|",
        "create event e22830_2 on schedule every 1 hour do\nbegin\n  call p22830_wait();\n  alter event e22830_2 on schedule every (select 8 from t1) hour;\nend|",
        "create event e22830_3 on schedule every 1 hour do\nbegin\n  call p22830_wait();\n  alter event e22830_3 on schedule every f22830() hour;\nend|",
        "create event e22830_4 on schedule every 1 hour do\nbegin\n  call p22830_wait();\n  alter event e22830_4 on schedule every (select f22830() from dual) hour;\nend|",
        "-- error ER_WRONG_VALUE\nCREATE EVENT new_event ON SCHEDULE AT (SELECT \"every day\") DO SELECT 1;",
        // actually a syntax error
        "-- error ER_SP_UNDECLARED_VAR\nGET DIAGNOSTICS var;",
        "-- error ER_SP_UNDECLARED_VAR\nCREATE PROCEDURE p1()\nBEGIN\n  GET DIAGNOSTICS var;\nEND|",
        "-- error ER_SP_UNDECLARED_VAR\nGET DIAGNOSTICS CONDITION 1 var;",
        "-- error ER_SP_UNDECLARED_VAR\nCREATE PROCEDURE p1()\nBEGIN\n  GET DIAGNOSTICS CONDITION 1 var;\nEND|",
        "-- error ER_SP_UNDECLARED_VAR\nCREATE PROCEDURE p1()\nBEGIN\n  DECLARE var CONDITION FOR SQLSTATE '12345';\n  GET DIAGNOSTICS CONDITION 1 var = NUMBER;\nEND|",
        "-- error ER_ILLEGAL_PRIVILEGE_LEVEL\nGRANT xyzzy ON PROCEDURE B30628160.p1 TO B30628160@localhost;",
        "-- error ER_DBACCESS_DENIED_ERROR\ncreate view information_schema.v1;",
        "-- error ER_SP_UNDECLARED_VAR\nCREATE PROCEDURE p1()\nBEGIN\n  DECLARE var CONDITION FOR SQLSTATE '01001';\n  GET DIAGNOSTICS CONDITION 1 var = NUMBER;\nEND|",
        "-- error ER_CHECK_NOT_IMPLEMENTED\nCREATE TABLE t1 (f1 INT NOT NULL) ENGINE=MyISAM ENCRYPTION='w';",
        "CREATE PROCEDURE sp1( )\nBEGIN\n    declare collate condition for sqlstate '02000';\n    declare exit handler for collate set @var2 = 1;\nEND//",
        "CREATE PROCEDURE h1 ()\nBEGIN\n    declare x1 int default 0;\n    BEGIN\n        declare condname1 condition for sqlstate '00000';\n      declare exit handler for condname1 set @x = 1;\n      set x1 = 1;\n      set x1 = 2;\n    END;\n    SELECT @x, x1;\nEND//",
        "CREATE PROCEDURE h1 ()\nBEGIN\n   DECLARE x1 INT DEFAULT 0;\n   BEGIN\n      DECLARE condname1 CONDITION FOR SQLSTATE '00000';\n      DECLARE EXIT HANDLER FOR SQLSTATE '00000' SET @x = 1;\n      SET x1 = 1;\n      SET x1 = 2;\n   END;\n   SELECT @x, x1;\nEND//",

        // misc
        "SET GLOBAL group_replication_single_primary_mode= -1;", // fuck you. your doc says BOOLEAN!
        "SET GLOBAL group_replication_single_primary_mode= 100;",
        "SET GLOBAL group_replication_enforce_update_everywhere_checks= -1;",
        "SET GLOBAL group_replication_enforce_update_everywhere_checks= 100;",

        // unresolved expressions
        "set @@global.binlog_checksum= IF(floor((rand()*1000)%2), \"CRC32\", \"NONE\");",
        "-- error ER_UNKNOWN_LOCALE\nset global LC_MESSAGES=convert((@@global.log_bin_trust_function_creators)\n    using cp1250);",
        "-- error ER_WRONG_ARGUMENTS\nSET INSERT_ID= NAME_CONST(a, a);",
        "set session_track_system_variables=f();",
        "set @@session.autocommit=t1_min(), @@session.autocommit=t1_max(),\n    @@session.autocommit=t1_min(), @@session.autocommit=t1_max(),\n    @@session.autocommit=t1_min(), @@session.autocommit=t1_max();",


        // won't fix - miscellaneous errors not caused by parser implementation ----------------------------------------

        // invalid variable name (differs from MySQL behavior, which is insane)
        "select @``;",
        "select @`endswithspace `;",
        "select @X2345678901234567890123456789012345678901234567890123456789012345;",

        // wrong sql_mode detected from tests
        'INSERT INTO t1 VALUES ("1\""), ("\"2");',

        // wrong perl filtering
        'else { } DROP TABLE t2',

        // test artifacts
        "-- error 0\n      ,ER_BLOB_KEY_WITHOUT_LENGTH\n      ,ER_UNSUPPORTED_ACTION_ON_GENERATED_COLUMN\n      ,ER_JSON_USED_AS_KEY\n    ;",

        // state emulation fails (probably because not processed includes)
        "set @@ndbinfo_max_bytes = @max_bytes;",
        "set @@ndbinfo_max_rows = @max_rows;",
        "SET @@global.max_allowed_packet:= @tmp_max;",
        "SET @@global.gtid_purged= @gtid_purged_init;",

        // invalid test code
        "REVOKE abc ON *.* FROM testuser@localhost;",
        "REVOKE abc ON *.* FROM testrole;",
        "REVOKE engineering ON *.* FROM joan, sally;",
        "REVOKE wp_administrators, engineering ON *.* FROM joan, sally;",

        // real syntax errors
        "CREATE TABLE t (\n    i  int NOT NULL AUTO_INCREMENT,\n    mt mediumtext NOT NULL,\n    c  varchar(10) NOT NULL,\n    ti tinyint(1) unsigned NOT NULL,\n    PRIMARY KEY (i, ti)\n  )\n  ENGINE = InnoDB AUTO_INCREMENT = 0\n  DEFAULT CHARSET = latin1, DATA DIRECTORY = '/tmp'\n  PARTITION BY LIST (ti) (\n    PARTITION p0 VALUES IN (0) ENGINE = InnoDB,\n    PARTITION p1 VALUES IN (1) DATA DIRECTORY = '/tmp' ,ENGINE = InnoDB\n  );", // syntax error near ENGINE at the end
        "PREPARE stmt FROM \"SELECT w, SUM(w) OVER (ROWS 3.14 PRECEDING) FROM t\";", // will fail on EXECUTE
        "CREATE TABLE empty (pri int(11) NOT NULL) ENGINE=NDB;", // invalid name
        "DROP TABLE empty;", // invalid name
        "DROP PROCEDURE sp1_thisisaveryverylongname234872934_thisisaveryverylongname234872934;", // name too long
        "DROP PROCEDURE sp1_thisisaveryverylongname234872934_thisisaveryverylongnameabcde;", // name too long
        "CREATE TABLESPACE ts1\n  ADD DATAFILE 'ts1_datafile.dat'\n  USE LOGFILE GROUP lg1\n  ENGINE=NDB ENCRYPTION='';", // invalid encryption
        "-- error ER_CHECK_NOT_IMPLEMENTED\nCREATE TABLESPACE ts1\n  ADD DATAFILE 'ts1_datafile.dat'\n  USE LOGFILE GROUP lg1\n  ENGINE=NDB ENCRYPTION='R';", // invalid encryption
        "-- error ER_TABLESPACE_MISSING_WITH_NAME\nDROP TABLESPACE s-- error ER_PARSE_ERROR\nDROP TABLESPACE s@bad;", // invalid test code: s#bad\n;

        // non-existing algorithms
        "CREATE TABLE t1(c1 INT PRIMARY KEY) COMPRESSION=\"zlibX\";",
        "ALTER TABLE t1 COMPRESSION='abcdefghijklmnopqrstuvwxyz';",

        // non-existing storage engines
        "ALTER TABLE t2 ENGINE=example;",
        "CREATE TABLE t_stmt (a VARCHAR(100)) ENGINE = EXAMPLE;",
        "CREATE TABLE t_slave_stmt (a INT) ENGINE = EXAMPLE;",
        "CREATE TABLE t7 (c1 INT) ENGINE= EXAMPLE;",
        "CREATE TABLE t1(a int) ENGINE=EXAMPLE;",
        "CREATE TABLE t10(a INT) ENGINE=EXAMPLE;",
        "CREATE TABLE t20(a INT) ENGINE=EXAMPLE;",
        "-- error ER_DISABLED_STORAGE_ENGINE\nCREATE TABLE t8 (c1 INT) ENGINE= EXAMPLE;",
        "-- error ER_DISABLED_STORAGE_ENGINE\nALTER TABLE t2 ENGINE=example;",
        "-- error ER_DISABLED_STORAGE_ENGINE\nCREATE TABLE t1(a int) ENGINE=EXAMPLE;",
        "-- error ER_BINLOG_ROW_MODE_AND_STMT_ENGINE\nCREATE TABLE t_stmt_new ENGINE = EXAMPLE SELECT * FROM t_stmt;",
        "CREATE TABLE t1 (a INT)\nENGINE=NonExistentEngine;",
        "CREATE TABLE t1 (a INT)\nENGINE=NonExistentEngine\nPARTITION BY HASH (a);",
        "ALTER TABLE t1 ENGINE=NonExistentEngine;",
        "ALTER TABLE t1\nPARTITION BY HASH (a)\n(PARTITION p0 ENGINE=InnoDB,\n PARTITION p1 ENGINE=NonExistentEngine);",
        "-- error ER_TOO_MANY_KEYS\nCREATE TABLE t1 (a int PRIMARY KEY) ENGINE=EXAMPLE;",
        "-- error ER_TOO_MANY_KEYS\nCREATE TABLE t1 (a int, KEY (a)) ENGINE=EXAMPLE;",
        "CREATE TABLE t1(a INT, b TEXT, KEY (a)) SECONDARY_ENGINE=MOCK;",

        // non-existing variables
        "-- error ER_WRONG_TYPE_FOR_VAR\nSET GLOBAL example_signed_long_var = -9223372036854775809;",
        "-- error ER_WRONG_TYPE_FOR_VAR\nSET GLOBAL example_signed_longlong_var = -9223372036854775809;",
        "-- error ER_WRONG_TYPE_FOR_VAR\nSET SESSION example_signed_long_thdvar = -9223372036854775809;",
        "-- error ER_WRONG_TYPE_FOR_VAR\nSET SESSION example_signed_longlong_thdvar = -9223372036854775809;",
        "-- error ER_WRONG_VALUE_FOR_VAR\nSET GLOBAL example_enum_var= impossible;",
        "-- error ER_WRONG_VALUE_FOR_VAR\nset global example_ulong_var=1111;",
        "SELECT @@GLOBAL.example_double_var;",
        "SELECT @@GLOBAL.example_signed_int_var;",
        "SELECT @@GLOBAL.example_signed_long_var IN (-2147483648, -9223372036854775808);",
        "SELECT @@GLOBAL.example_signed_long_var IN (2147483647, 9223372036854775807);",
        "SELECT @@GLOBAL.example_signed_long_var;",
        "SELECT @@GLOBAL.example_signed_longlong_var;",
        "SELECT @@SESSION.example_create_count_thdvar;",
        "SELECT @@SESSION.example_double_thdvar;",
        "SELECT @@SESSION.example_last_create_thdvar;",
        "SELECT @@SESSION.example_signed_int_thdvar;",
        "SELECT @@SESSION.example_signed_long_thdvar IN (-2147483648, -9223372036854775808);",
        "SELECT @@SESSION.example_signed_long_thdvar IN (2147483647, 9223372036854775807);",
        "SELECT @@SESSION.example_signed_long_thdvar;",
        "SELECT @@SESSION.example_signed_longlong_thdvar;",
        "SELECT @@global.example_enum_var = 'e2';",
        "SET GLOBAL example_double_var = -0.1;",
        "SET GLOBAL example_double_var = 0.000001;",
        "SET GLOBAL example_double_var = 0.4;",
        "SET GLOBAL example_double_var = 1000.51;",
        "SET GLOBAL example_double_var = 123.456789;",
        "SET GLOBAL example_double_var = 500;",
        "SET GLOBAL example_double_var = 999.999999;",
        "SET GLOBAL example_enum_var= e1;",
        "SET GLOBAL example_enum_var= e2;",
        "SET GLOBAL example_signed_int_var = -100;",
        "SET GLOBAL example_signed_int_var = -2147483648;",
        "SET GLOBAL example_signed_int_var = -2147483649;",
        "SET GLOBAL example_signed_int_var = 0;",
        "SET GLOBAL example_signed_int_var = 100;",
        "SET GLOBAL example_signed_int_var = 2147483647;",
        "SET GLOBAL example_signed_int_var = 2147483648;",
        "SET GLOBAL example_signed_long_var = -100;",
        "SET GLOBAL example_signed_long_var = -9223372036854775808;",
        "SET GLOBAL example_signed_long_var = -9223372036854775809;",
        "SET GLOBAL example_signed_long_var = 0;",
        "SET GLOBAL example_signed_long_var = 100;",
        "SET GLOBAL example_signed_long_var = 9223372036854775807;",
        "SET GLOBAL example_signed_long_var = 9223372036854775808;",
        "SET GLOBAL example_signed_longlong_var = -100;",
        "SET GLOBAL example_signed_longlong_var = -9223372036854775808;",
        "SET GLOBAL example_signed_longlong_var = -9223372036854775809;",
        "SET GLOBAL example_signed_longlong_var = 0;",
        "SET GLOBAL example_signed_longlong_var = 100;",
        "SET GLOBAL example_signed_longlong_var = 9223372036854775807;",
        "SET GLOBAL example_signed_longlong_var = 9223372036854775808;",
        "SET SESSION example_create_count_thdvar = 0;",
        "SET SESSION example_double_thdvar = -0.1;",
        "SET SESSION example_double_thdvar = 0.000001;",
        "SET SESSION example_double_thdvar = 0.4;",
        "SET SESSION example_double_thdvar = 1000.51;",
        "SET SESSION example_double_thdvar = 123.456789;",
        "SET SESSION example_double_thdvar = 500;",
        "SET SESSION example_double_thdvar = 999.999999;",
        "SET SESSION example_last_create_thdvar = '';",
        "SET SESSION example_signed_int_thdvar = -100;",
        "SET SESSION example_signed_int_thdvar = -2147483648;",
        "SET SESSION example_signed_int_thdvar = -2147483649;",
        "SET SESSION example_signed_int_thdvar = 0;",
        "SET SESSION example_signed_int_thdvar = 100;",
        "SET SESSION example_signed_int_thdvar = 2147483647;",
        "SET SESSION example_signed_int_thdvar = 2147483648;",
        "SET SESSION example_signed_long_thdvar = -100;",
        "SET SESSION example_signed_long_thdvar = -9223372036854775808;",
        "SET SESSION example_signed_long_thdvar = -9223372036854775809;",
        "SET SESSION example_signed_long_thdvar = 0;",
        "SET SESSION example_signed_long_thdvar = 100;",
        "SET SESSION example_signed_long_thdvar = 9223372036854775807;",
        "SET SESSION example_signed_long_thdvar = 9223372036854775808;",
        "SET SESSION example_signed_longlong_thdvar = -100;",
        "SET SESSION example_signed_longlong_thdvar = -9223372036854775808;",
        "SET SESSION example_signed_longlong_thdvar = -9223372036854775809;",
        "SET SESSION example_signed_longlong_thdvar = 0;",
        "SET SESSION example_signed_longlong_thdvar = 100;",
        "SET SESSION example_signed_longlong_thdvar = 9223372036854775807;",
        "SET SESSION example_signed_longlong_thdvar = 9223372036854775808;",
        "select @@global.example_ulong_var;",
        "set global example_enum_var= e1;",
        "set global example_ulong_var=1111;",
        "set global example_ulong_var=1111;",
        "set global example_ulong_var=500;",
        "-- error ER_PERSIST_ONLY_ACCESS_DENIED_ERROR\nSET PERSIST_ONLY test_component.sensitive_ro_string_1 = 'haha';",
        "-- error ER_PERSIST_ONLY_ACCESS_DENIED_ERROR\nSET PERSIST_ONLY test_component.sensitive_ro_string_2 = 'hoho';",
        "-- error ER_PERSIST_ONLY_ACCESS_DENIED_ERROR\nSET PERSIST_ONLY test_component.sensitive_ro_string_3 = 'hehe';",
        "-- error ER_PERSIST_ONLY_ACCESS_DENIED_ERROR\nSET PERSIST_ONLY test_component.sensitive_string_1 = 'haha';",
        "-- error ER_PERSIST_ONLY_ACCESS_DENIED_ERROR\nSET PERSIST_ONLY test_component.sensitive_string_2 = 'hoho';",
        "-- error ER_PERSIST_ONLY_ACCESS_DENIED_ERROR\nSET PERSIST_ONLY test_component.sensitive_string_3 = 'hehe';",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSELECT @@global.test_component.sensitive_ro_string_1;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSELECT @@global.test_component.sensitive_string_1;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSELECT @@session.test_component.sensitive_ro_string_1;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSELECT @@session.test_component.sensitive_string_1;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component.sensitive_string_1 = 'haha';",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component.sensitive_string_2 = 'hoho';",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component.sensitive_string_3 = 'hehe';",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET PERSIST test_component.sensitive_string_1 = 'haha';",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET PERSIST test_component.sensitive_string_2 = 'hoho';",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET PERSIST test_component.sensitive_string_3 = 'hehe';",
        "SELECT @@global.test_component.sensitive_ro_string_1;",
        "SELECT @@global.test_component.sensitive_string_1;",
        "SET GLOBAL test_component.sensitive_string_1 = 'haha';",
        "SET PERSIST test_component.sensitive_string_1 = 'haha';",
        "SET PERSIST_ONLY test_component.sensitive_string_1 = 'haha';",
        "SET PERSIST_ONLY test_component.sensitive_ro_string_1 = 'haha';",
        "SET GLOBAL test_component.sensitive_string_1 = \"haha\";",
        "SET PERSIST test_component.sensitive_string_2 = \"haha\";",
        "SET @@test_security_context_get_field = \"user\", @@test_security_context_get_value = \"root\";",
        "SET @@test_security_context_get_field = \"user\", @@test_security_context_get_value = \"root-err\";",
        "SET @@test_security_context_get_field = \"host\", @@test_security_context_get_value = \"localhost\";",
        "SET @@test_security_context_get_field = \"ip\";",
        "SET @@test_security_context_get_field = \"priv_user\", @@test_security_context_get_value = \"root\";",
        "SET @@test_security_context_get_field = \"priv_host\", @@test_security_context_get_value = \"localhost\";",
        "SET @@test_security_context_get_field = \"sec_ctx_test\";",
        "SET GLOBAL example_ulong_var = 100;",
        "SET GLOBAL example_enum_var = e1;",
        "SET GLOBAL example_double_var = 100.9990;",
        "SET GLOBAL example_double_thdvar = 101.9991;",
        "SET SESSION example_double_thdvar = 102.9992;",
        "SET GLOBAL example_ulong_var = 200;",
        "SET GLOBAL example_enum_var = e2;",
        "SET GLOBAL example_double_var = 200.8880;",
        "SET GLOBAL example_double_thdvar = 201.8881;",
        "SET SESSION example_double_thdvar = 202.8882;",
        "SET GLOBAL example_ulong_var = 300;",
        "SET GLOBAL example_enum_var = e1;",
        "SET GLOBAL example_double_var = 301.0000;",
        "SET GLOBAL example_double_thdvar = 302.0000;",
        "SET SESSION example_double_thdvar = 300.0000;",
        "SET SESSION example_double_thdvar = 300.1111;",
        "SET SESSION example_double_thdvar = 300.2222;",
        "SET SESSION example_double_thdvar = 300.3333;",
        "SET SESSION example_double_thdvar = 311.1111;",
        "SET SESSION example_double_thdvar = 322.2222;",
        "SET SESSION example_double_thdvar = 333.3333;",
        "SELECT @@test_component.int_sys_var;",
        "SELECT @@global.test_component.int_sys_var;",
        "SELECT @@global.test_component.bool_sys_var;",
        "SELECT @@test_component.int_sys_var, @@test_component.bool_sys_var;",
        "SET GLOBAL test_component.int_sys_var=7;",
        "SET GLOBAL test_component.int_sys_var=1234567;",
        "SET GLOBAL test_component.int_sys_var=-1;",
        "SET GLOBAL test_component.int_sys_var=123, test_component.bool_sys_var=0;",
        "-- error ER_GLOBAL_VARIABLE\nSET SESSION test_component.int_sys_var=123;",
        "SELECT @@test_component.enum_sys_var;",
        "SET GLOBAL test_component.enum_sys_var=\"LOW\";",
        "SELECT @@test_component.str_sys_var;",
        "SET GLOBAL test_component.str_sys_var=\"dictionary.txt\";",
        "SET GLOBAL test_component.str_sys_var=default;",
        "SELECT @@test_component.uint_sys_var;",
        "SET GLOBAL test_component.uint_sys_var=12345678;",
        "SET GLOBAL test_component.uint_sys_var=default;",
        "SELECT @@test_component.long_sys_var;",
        "SET GLOBAL test_component.long_sys_var=1234567890;",
        "SET GLOBAL test_component.long_sys_var=default;",
        "SELECT @@test_component.ulong_sys_var;",
        "SET GLOBAL test_component.ulong_sys_var=1234567890;",
        "SET GLOBAL test_component.ulong_sys_var=default;",
        "SELECT @@test_component.longlong_sys_var;",
        "SET GLOBAL test_component.longlong_sys_var=1234567890;",
        "SET GLOBAL test_component.longlong_sys_var=default;",
        "SELECT @@test_component.ulonglong_sys_var;",
        "SET GLOBAL test_component.ulonglong_sys_var=1234567890;",
        "SET GLOBAL test_component.ulonglong_sys_var=default;",
        "SET PERSIST test_component.int_sys_var=7;",
        "RESET PERSIST `test_component.int_sys_var`;",
        "SET GLOBAL test_component.str_sys_var=\"salve.txt\";",
        "SET GLOBAL test_component_str.str_sys_var=\"salve.txt\";",
        "SELECT @@test_component_str.str_sys_var;",
        "CREATE PROCEDURE p1(x VARCHAR(32)) SET @@GLOBAL.test_component.str_sys_var = x;",
        "CREATE PROCEDURE p2() SELECT @@test_component.str_sys_var;",
        "SET GLOBAL test_component_str.str_sys_var=\"dictionary.txt\";",
        "SET GLOBAL test_component_str.str_sys_var=default;",
        "SELECT @@test_component_int.uint_sys_var;",
        "SET GLOBAL test_component_int.uint_sys_var=12345678;",
        "SET GLOBAL test_component_int.uint_sys_var=default;",
        "SELECT @@test_component_int.int_sys_var;",
        "SET GLOBAL test_component_int.int_sys_var=12345678;",
        "SET GLOBAL test_component_int.int_sys_var=default;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component_str.str_sys_var=\"dictionary.txt\";",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component.long_sys_var=1234567890;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component.ulong_sys_var=1234567890;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component.longlong_sys_var=1234567890;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component_int.uint_sys_var=12345678;",
        "-- error ER_SPECIFIC_ACCESS_DENIED_ERROR\nSET GLOBAL test_component_int.int_sys_var=12345678;",
        "SET GLOBAL test_component.str_sys_var=\"Before crash\";",
        "SET GLOBAL test_component.int_sys_var=123;",
    ];

}
