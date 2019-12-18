<?php declare(strict_types = 1);

namespace SqlFtw\Parser;

use SqlFtw\Tests\Assert;

require __DIR__ . '/../../bootstrap.php';

// ALTER FUNCTION func_name [characteristic ...]
Assert::parse("ALTER FUNCTION foo");
Assert::parse("ALTER FUNCTION foo COMMENT 'bar'");
Assert::parse("ALTER FUNCTION foo LANGUAGE SQL");
Assert::parse("ALTER FUNCTION foo CONTAINS SQL");
Assert::parse("ALTER FUNCTION foo NO SQL");
Assert::parse("ALTER FUNCTION foo READS SQL DATA");
Assert::parse("ALTER FUNCTION foo MODIFIES SQL DATA");
Assert::parse("ALTER FUNCTION foo SQL SECURITY DEFINER");
Assert::parse("ALTER FUNCTION foo SQL SECURITY INVOKER");

Assert::parse("ALTER FUNCTION foo COMMENT 'bar' LANGUAGE SQL");
Assert::parse("ALTER FUNCTION foo LANGUAGE SQL COMMENT 'bar'", "ALTER FUNCTION foo COMMENT 'bar' LANGUAGE SQL");


// ALTER PROCEDURE proc_name [characteristic ...]
Assert::parse("ALTER PROCEDURE foo");
Assert::parse("ALTER PROCEDURE foo COMMENT 'bar'");
Assert::parse("ALTER PROCEDURE foo LANGUAGE SQL");
Assert::parse("ALTER PROCEDURE foo CONTAINS SQL");
Assert::parse("ALTER PROCEDURE foo NO SQL");
Assert::parse("ALTER PROCEDURE foo READS SQL DATA");
Assert::parse("ALTER PROCEDURE foo MODIFIES SQL DATA");
Assert::parse("ALTER PROCEDURE foo SQL SECURITY DEFINER");
Assert::parse("ALTER PROCEDURE foo SQL SECURITY INVOKER");

Assert::parse("ALTER PROCEDURE foo COMMENT 'bar' LANGUAGE SQL");
Assert::parse("ALTER PROCEDURE foo LANGUAGE SQL COMMENT 'bar'", "ALTER PROCEDURE foo COMMENT 'bar' LANGUAGE SQL");


// CREATE [DEFINER = { user | CURRENT_USER }] FUNCTION sp_name ([func_parameter[,...]]) RETURNS type [characteristic ...] routine_body
Assert::parse("CREATE FUNCTION foo() RETURNS INT BEGIN RETURN 1 END");
Assert::parse("CREATE DEFINER = CURRENT_USER FUNCTION foo() RETURNS INT BEGIN RETURN 1 END");
Assert::parse("CREATE DEFINER = 'admin'@'localhost' FUNCTION foo() RETURNS INT BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo(bar INT) RETURNS INT BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo(bar INT, baz CHAR(3)) RETURNS INT BEGIN RETURN 1 END");

Assert::parse("CREATE FUNCTION foo() RETURNS INT COMMENT 'bar' BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo() RETURNS INT LANGUAGE SQL BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo() RETURNS INT CONTAINS SQL BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo() RETURNS INT NO SQL BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo() RETURNS INT READS SQL DATA BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo() RETURNS INT MODIFIES SQL DATA BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo() RETURNS INT SQL SECURITY DEFINER BEGIN RETURN 1 END");
Assert::parse("CREATE FUNCTION foo() RETURNS INT SQL SECURITY INVOKER BEGIN RETURN 1 END");

Assert::parse("CREATE FUNCTION foo() RETURNS INT COMMENT 'bar' LANGUAGE SQL BEGIN RETURN 1 END");
Assert::parse(
    "CREATE FUNCTION foo() RETURNS INT LANGUAGE SQL COMMENT 'bar' BEGIN RETURN 1 END",
    "CREATE FUNCTION foo() RETURNS INT COMMENT 'bar' LANGUAGE SQL BEGIN RETURN 1 END",
);


// CREATE [DEFINER = { user | CURRENT_USER }] PROCEDURE sp_name ([proc_parameter[,...]]) [characteristic ...] routine_body
Assert::parse("CREATE PROCEDURE foo() BEGIN SELECT 1 END");
Assert::parse("CREATE DEFINER = CURRENT_USER PROCEDURE foo() BEGIN SELECT 1 END");
Assert::parse("CREATE DEFINER = 'admin'@'localhost' PROCEDURE foo() BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo(bar INT) BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo(bar INT, baz CHAR(3)) BEGIN SELECT 1 END");

Assert::parse("CREATE PROCEDURE foo() COMMENT 'bar' BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo() LANGUAGE SQL BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo() CONTAINS SQL BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo() NO SQL BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo() READS SQL DATA BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo() MODIFIES SQL DATA BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo() SQL SECURITY DEFINER BEGIN SELECT 1 END");
Assert::parse("CREATE PROCEDURE foo() SQL SECURITY INVOKER BEGIN SELECT 1 END");

Assert::parse("CREATE PROCEDURE foo() COMMENT 'bar' LANGUAGE SQL BEGIN SELECT 1 END");
Assert::parse(
    "CREATE PROCEDURE foo() LANGUAGE SQL COMMENT 'bar' BEGIN SELECT 1 END",
    "CREATE PROCEDURE foo() COMMENT 'bar' LANGUAGE SQL BEGIN SELECT 1 END",
);


// DROP FUNCTION [IF EXISTS] sp_name
Assert::parse("DROP FUNCTION foo");
Assert::parse("DROP FUNCTION IF EXISTS foo");


// DROP PROCEDURE [IF EXISTS] sp_name
Assert::parse("DROP PROCEDURE foo");
Assert::parse("DROP PROCEDURE IF EXISTS foo");