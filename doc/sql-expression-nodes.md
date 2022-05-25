
Expression nodes:

note: classes in **bold**, interfaces in *italic*

- *ExpressionNode*
  - *RootNode* - node that can be used on highest level anywhere (assignment, return etc.)
    - **CaseExpression** - `CASE x THEN y ELSE z END`
    - **CollateExpression** - `expr COLLATE collation`
    - **CurlyExpression** - `{identifier expr}`
    - **ExistsExpression** - `EXISTS (SELECT ...)`
    - **FunctionCall** - e.g. `AVG([DISTINCT] x) OVER ...`
    - **Identifier** - e.g. `name, @name, *`
    - *Literal* - value, placeholder or value promise (e.g. `DEFAULT`)
    - *KeywordLiteral* - e.g. `DEFAULT`, `UNKNOWN`, `ON`, `OFF`...
      - **AllLiteral** - `ALL`
      - **DefaultLiteral** - `DEFAULT`
      - **UnknownLiteral** - `UNKNOWN`
    - **Placeholder** - ?
    - *ValueLiteral* - concrete value
      - **BinaryLiteral** - e.g. `0b001101110`
      - **HexadecimalLiteral** - e.g. `0x001F`
      - **IntervalLiteral** - e.g. `INTERVAL 6 DAYS`
      - **NumberLiteral** - e.g. `-1.23e-4`
        - **IntLiteral** - e.g. `-123`
          - **UintLiteral** - e.g. `123`
      - **StringLiteral** - e.g. `"start " \n 'middle ' \n "end"`
      - **NullLiteral** (*KeywordLiteral*) - `NULL`
      - **BooleanLiteral** (*KeywordLiteral*) - `TRUE` | `FALSE`
      - **OnOffLiteral** (*KeywordLiteral*) - `ON` | `OFF`
    - **MatchExpression** - `MATCH x AGAINST y`
    - *OperatorExpression*
      - **AssignOperator** - `variable := expr`
      - **BinaryOperator** - e.g. `x + y`
      - **TernaryOperator** - e.g. `x BETWEEN y AND z`
      - **UnaryOperator** - e.g. `NOT x`
    - **Parentheses** - `(...)`
  - **AliasExpression** - `expr AS alias` - used on highest level only in queries
  - **CastType** - e.g. `CAST(expr AS type)` - used as function parameter
  - **Charset** - e.g. in `CONVERT(expr USING charset_name)` - used as function parameter
  - **JsonErrorCondition** - e.g. `DEFAULT 123 ON ERROR` - used as function parameter
  - *JsonTableColumn* - used as function parameter
    - **JsonTableExistPathColumn**
    - **JsonTableOrdinalityColumn**
    - **JsonTablePathColumn**
    - **JsonTableNestedColumn**
  - **ListExpression** - `..., ..., ...` - used for lists in Parentheses
  - **OrderByExpression** - `{col_name | expr | position} [ASC | DESC]`  - used as function parameter
  - **RowExpression** - `ROW (...[, ...])`  - used as operator parameter
  - **Subquery** - `(SELECT ...)`  - used as operator parameter

todo:
- introduce UserVariable (@foo), SystemVariable (@GLOBAL.foo) ???
- make Collation, ColumnName, QualifiedName, UserName part of the Expression hierarchy ???
- marking interfaces for RootNode and ArgumentNode ???
- **ThreeStateValue** as *Literal* ???