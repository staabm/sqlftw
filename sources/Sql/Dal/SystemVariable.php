<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal;

use SqlFtw\Sql\Feature;
use SqlFtw\Sql\SqlEnum;

class SystemVariable extends SqlEnum implements Feature
{

    public const ACTIVATE_ALL_ROLES_ON_LOGIN = 'activate_all_roles_on_login';
    public const ADMIN_SSL_CA = 'admin_ssl_ca';
    public const ADMIN_SSL_CAPATH = 'admin_ssl_capath';
    public const ADMIN_SSL_CERT = 'admin_ssl_cert';
    public const ADMIN_SSL_CIPHER = 'admin_ssl_cipher';
    public const ADMIN_TLS_CIPHERSUITES = 'admin_tls_ciphersuites';
    public const ADMIN_SSL_CRL = 'admin_ssl_crl';
    public const ADMIN_SSL_CRLPATH = 'admin_ssl_crlpath';
    public const ADMIN_SSL_KEY = 'admin_ssl_key';
    public const ADMIN_TLS_VERSION = 'admin_tls_version';
    public const AUTO_INCREMENT_INCREMENT = 'auto_increment_increment';
    public const AUTO_INCREMENT_OFFSET = 'auto_increment_offset';
    public const AUTOCOMMIT = 'autocommit';
    public const AUTOMATIC_SP_PRIVILEGES = 'automatic_sp_privileges';
    public const AVOID_TEMPORAL_UPGRADE = 'avoid_temporal_upgrade';
    public const BACK_LOG = 'back_log';
    public const BASEDIR = 'basedir';
    public const BIG_TABLES = 'big_tables';
    public const BIND_ADDRESS = 'bind_address';
    public const BINLOG_CACHE_SIZE = 'binlog_cache_size';
    public const BINLOG_CHECKSUM = 'binlog_checksum';
    public const BINLOG_DIRECT_NON_TRANSACTIONAL_UPDATES = 'binlog_direct_non_transactional_updates';
    public const BINLOG_ENCRYPTION = 'binlog_encryption';
    public const BINLOG_ERROR_ACTION = 'binlog_error_action';
    public const BINLOG_EXPIRE_LOGS_AUTO_PURGE = 'binlog_expire_logs_auto_purge';
    public const BINLOG_EXPIRE_LOGS_SECONDS = 'binlog_expire_logs_seconds';
    public const BINLOG_FORMAT = 'binlog_format';
    public const BINLOG_GROUP_COMMIT_SYNC_DELAY = 'binlog_group_commit_sync_delay';
    public const BINLOG_GROUP_COMMIT_SYNC_NO_DELAY_COUNT = 'binlog_group_commit_sync_no_delay_count';
    public const BINLOG_GTID_SIMPLE_RECOVERY = 'binlog_gtid_simple_recovery';
    public const BINLOG_MAX_FLUSH_QUEUE_TIME = 'binlog_max_flush_queue_time';
    public const BINLOG_ORDER_COMMITS = 'binlog_order_commits';
    public const BINLOG_ROW_IMAGE = 'binlog_row_image';
    public const BINLOG_ROW_METADATA = 'binlog_row_metadata';
    public const BINLOG_ROWS_QUERY_LOG_EVENTS = 'binlog_rows_query_log_events';
    public const BINLOG_STMT_CACHE_SIZE = 'binlog_stmt_cache_size';
    public const BINLOG_TRANSACTION_COMPRESSION = 'binlog_transaction_compression';
    public const BINLOG_TRANSACTION_COMPRESSION_LEVEL_ZSTD = 'binlog_transaction_compression_level_zstd';
    public const BINLOG_TRANSACTION_DEPENDENCY_TRACKING = 'binlog_transaction_dependency_tracking';
    public const BLOCK_ENCRYPTION_MODE = 'block_encryption_mode';
    public const BULK_INSERT_BUFFER_SIZE = 'bulk_insert_buffer_size';
    public const CHARACTER_SET_CLIENT = 'character_set_client';
    public const CHARACTER_SET_CONNECTION = 'character_set_connection';
    public const CHARACTER_SET_DATABASE = 'character_set_database';
    public const CHARACTER_SET_FILESYSTEM = 'character_set_filesystem';
    public const CHARACTER_SET_RESULTS = 'character_set_results';
    public const CHARACTER_SET_SERVER = 'character_set_server';
    public const CHARACTER_SET_SYSTEM = 'character_set_system';
    public const CHARACTER_SETS_DIR = 'character_sets_dir';
    public const CHECK_PROXY_USERS = 'check_proxy_users';
    public const CLONE_BLOCK_DDL = 'clone_block_ddl';
    public const CLONE_BUFFER_SIZE = 'clone_buffer_size';
    public const CLONE_DDL_TIMEOUT = 'clone_ddl_timeout';
    public const CLONE_DONOR_TIMEOUT_AFTER_NETWORK_FAILURE = 'clone_donor_timeout_after_network_failure';
    public const CLONE_MAX_CONCURRENCY = 'clone_max_concurrency';
    public const CLONE_VALID_DONOR_LIST = 'clone_valid_donor_list';
    public const COLLATION_CONNECTION = 'collation_connection';
    public const COLLATION_DATABASE = 'collation_database';
    public const COLLATION_SERVER = 'collation_server';
    public const COMPLETION_TYPE = 'completion_type';
    public const CONCURRENT_INSERT = 'concurrent_insert';
    public const CONNECT_TIMEOUT = 'connect_timeout';
    public const CONNECTION_CONTROL_FAILED_CONNECTIONS_THRESHOLD = 'connection_control_failed_connections_threshold';
    public const CONNECTION_CONTROL_MAX_CONNECTION_DELAY = 'connection_control_max_connection_delay';
    public const CONNECTION_CONTROL_MIN_CONNECTION_DELAY = 'connection_control_min_connection_delay';
    public const CORE_FILE = 'core_file';
    public const DATADIR = 'datadir';
    public const DATE_FORMAT = 'date_format';
    public const DATETIME_FORMAT = 'datetime_format';
    public const DEBUG = 'DEBUG';
    public const DEBUG_SYNC = 'DEBUG_SYNC';
    public const DEFAULT_AUTHENTICATION_PLUGIN = 'default_authentication_plugin';
    public const DEFAULT_PASSWORD_LIFETIME = 'default_password_lifetime';
    public const DEFAULT_STORAGE_ENGINE = 'default_storage_engine';
    public const DEFAULT_TMP_STORAGE_ENGINE = 'default_tmp_storage_engine';
    public const DEFAULT_WEEK_FORMAT = 'default_week_format';
    public const DELAY_KEY_WRITE = 'delay_key_write';
    public const DELAYED_INSERT_LIMIT = 'delayed_insert_limit';
    public const DELAYED_INSERT_TIMEOUT = 'delayed_insert_timeout';
    public const DELAYED_QUEUE_SIZE = 'delayed_queue_size';
    public const DISABLED_STORAGE_ENGINES = 'disabled_storage_engines';
    public const DISCONNECT_ON_EXPIRED_PASSWORD = 'disconnect_on_expired_password';
    public const DIV_PRECISION_INCREMENT = 'div_precision_increment';
    public const END_MARKERS_IN_JSON = 'end_markers_in_json';
    public const ENFORCE_GTID_CONSISTENCY = 'enforce_gtid_consistency';
    public const ENGINE_CONDITION_PUSHDOWN = 'engine_condition_pushdown';
    public const EQ_RANGE_INDEX_DIVE_LIMIT = 'eq_range_index_dive_limit';
    public const ERROR_COUNT = 'error_count';
    public const EVENT_SCHEDULER = 'event_scheduler';
    public const EXPIRE_LOGS_DAYS = 'expire_logs_days';
    public const EXPLICIT_DEFAULTS_FOR_TIMESTAMP = 'explicit_defaults_for_timestamp';
    public const EXTERNAL_USER = 'external_user';
    public const FLUSH = 'flush';
    public const FLUSH_TIME = 'flush_time';
    public const FOREIGN_KEY_CHECKS = 'foreign_key_checks';
    public const FT_BOOLEAN_SYNTAX = 'ft_boolean_syntax';
    public const FT_MAX_WORD_LEN = 'ft_max_word_len';
    public const FT_MIN_WORD_LEN = 'ft_min_word_len';
    public const FT_QUERY_EXPANSION_LIMIT = 'ft_query_expansion_limit';
    public const FT_STOPWORD_FILE = 'ft_stopword_file';
    public const GENERAL_LOG = 'general_log';
    public const GENERAL_LOG_FILE = 'general_log_file';
    public const GROUP_CONCAT_MAX_LEN = 'group_concat_max_len';
    public const GTID_EXECUTED_COMPRESSION_PERIOD = 'gtid_executed_compression_period';
    public const GTID_MODE = 'gtid_mode';
    public const GTID_NEXT = 'gtid_next';
    public const GTID_OWNED = 'gtid_owned';
    public const GTID_PURGED = 'gtid_purged';
    public const HAVE_COMPRESS = 'have_compress';
    public const HAVE_CRYPT = 'have_crypt';
    public const HAVE_DYNAMIC_LOADING = 'have_dynamic_loading';
    public const HAVE_GEOMETRY = 'have_geometry';
    public const HAVE_OPENSSL = 'have_openssl';
    public const HAVE_PROFILING = 'have_profiling';
    public const HAVE_QUERY_CACHE = 'have_query_cache';
    public const HAVE_RTREE_KEYS = 'have_rtree_keys';
    public const HAVE_SSL = 'have_ssl';
    public const HAVE_STATEMENT_TIMEOUT = 'have_statement_timeout';
    public const HAVE_SYMLINK = 'have_symlink';
    public const HOST_CACHE_SIZE = 'host_cache_size';
    public const HOSTNAME = 'hostname';
    public const IDENTITY = 'identity';
    public const IGNORE_BUILTIN_INNODB = 'ignore_builtin_innodb';
    public const IGNORE_DB_DIRS = 'ignore_db_dirs'; // removed in 8.0
    public const INFORMATION_SCHEMA_STATS_EXPIRY = 'information_schema_stats_expiry';
    public const INIT_CONNECT = 'init_connect';
    public const INIT_FILE = 'init_file';
    public const INIT_SLAVE = 'init_slave';
    public const INNODB_ADAPTIVE_FLUSHING = 'innodb_adaptive_flushing';
    public const INNODB_ADAPTIVE_FLUSHING_LWM = 'innodb_adaptive_flushing_lwm';
    public const INNODB_ADAPTIVE_HASH_INDEX = 'innodb_adaptive_hash_index';
    public const INNODB_ADAPTIVE_HASH_INDEX_PARTS = 'innodb_adaptive_hash_index_parts';
    public const INNODB_ADAPTIVE_MAX_SLEEP_DELAY = 'innodb_adaptive_max_sleep_delay';
    public const INNODB_API_BK_COMMIT_INTERVAL = 'innodb_api_bk_commit_interval';
    public const INNODB_API_DISABLE_ROWLOCK = 'innodb_api_disable_rowlock';
    public const INNODB_API_ENABLE_BINLOG = 'innodb_api_enable_binlog';
    public const INNODB_API_ENABLE_MDL = 'innodb_api_enable_mdl';
    public const INNODB_API_TRX_LEVEL = 'innodb_api_trx_level';
    public const INNODB_AUTOEXTEND_INCREMENT = 'innodb_autoextend_increment';
    public const INNODB_AUTOINC_LOCK_MODE = 'innodb_autoinc_lock_mode';
    public const INNODB_BUF_FLUSH_LIST_NOW = 'innodb_buf_flush_list_now';
    public const INNODB_BUFFER_POOL_CHUNK_SIZE = 'innodb_buffer_pool_chunk_size';
    public const INNODB_BUFFER_POOL_DUMP_AT_SHUTDOWN = 'innodb_buffer_pool_dump_at_shutdown';
    public const INNODB_BUFFER_POOL_DUMP_NOW = 'innodb_buffer_pool_dump_now';
    public const INNODB_BUFFER_POOL_DUMP_PCT = 'innodb_buffer_pool_dump_pct'; // added in 5.7
    public const INNODB_BUFFER_POOL_FILENAME = 'innodb_buffer_pool_filename';
    public const INNODB_BUFFER_POOL_INSTANCES = 'innodb_buffer_pool_instances';
    public const INNODB_BUFFER_POOL_LOAD_ABORT = 'innodb_buffer_pool_load_abort';
    public const INNODB_BUFFER_POOL_LOAD_AT_STARTUP = 'innodb_buffer_pool_load_at_startup';
    public const INNODB_BUFFER_POOL_LOAD_NOW = 'innodb_buffer_pool_load_now';
    public const INNODB_BUFFER_POOL_SIZE = 'innodb_buffer_pool_size';
    public const INNODB_CHANGE_BUFFER_MAX_SIZE = 'innodb_change_buffer_max_size';
    public const INNODB_CHANGE_BUFFERING = 'innodb_change_buffering';
    public const INNODB_CHECKSUM_ALGORITHM = 'innodb_checksum_algorithm';
    public const INNODB_CHECKSUMS = 'innodb_checksums';
    public const INNODB_CMP_PER_INDEX_ENABLED = 'innodb_cmp_per_index_enabled';
    public const INNODB_COMMIT_CONCURRENCY = 'innodb_commit_concurrency';
    public const INNODB_COMPRESSION_FAILURE_THRESHOLD_PCT = 'innodb_compression_failure_threshold_pct';
    public const INNODB_COMPRESSION_LEVEL = 'innodb_compression_level';
    public const INNODB_COMPRESSION_PAD_PCT_MAX = 'innodb_compression_pad_pct_max';
    public const INNODB_CONCURRENCY_TICKETS = 'innodb_concurrency_tickets';
    public const INNODB_DATA_FILE_PATH = 'innodb_data_file_path';
    public const INNODB_DATA_HOME_DIR = 'innodb_data_home_dir';
    public const INNODB_DEFAULT_ROW_FORMAT = 'innodb_default_row_format'; // added in 5.7
    public const INNODB_DISABLE_SORT_FILE_CACHE = 'innodb_disable_sort_file_cache';
    public const INNODB_DOUBLEWRITE = 'innodb_doublewrite';
    public const INNODB_FAST_SHUTDOWN = 'innodb_fast_shutdown';
    public const INNODB_FILE_FORMAT = 'innodb_file_format';
    public const INNODB_FILE_FORMAT_CHECK = 'innodb_file_format_check';
    public const INNODB_FILE_FORMAT_MAX = 'innodb_file_format_max';
    public const INNODB_FILE_PER_TABLE = 'innodb_file_per_table';
    public const INNODB_FILL_FACTOR = 'innodb_fill_factor'; // added in 5.7
    public const INNODB_FLUSH_LOG_AT_TIMEOUT = 'innodb_flush_log_at_timeout';
    public const INNODB_FLUSH_LOG_AT_TRX_COMMIT = 'innodb_flush_log_at_trx_commit';
    public const INNODB_FLUSH_METHOD = 'innodb_flush_method';
    public const INNODB_FLUSH_NEIGHBORS = 'innodb_flush_neighbors';
    public const INNODB_FLUSH_SYNC = 'innodb_flush_sync';
    public const INNODB_FLUSHING_AVG_LOOPS = 'innodb_flushing_avg_loops';
    public const INNODB_FORCE_LOAD_CORRUPTED = 'innodb_force_load_corrupted';
    public const INNODB_FORCE_RECOVERY = 'innodb_force_recovery';
    public const INNODB_FT_AUX_TABLE = 'innodb_ft_aux_table';
    public const INNODB_FT_CACHE_SIZE = 'innodb_ft_cache_size';
    public const INNODB_FT_ENABLE_DIAG_PRINT = 'innodb_ft_enable_diag_print';
    public const INNODB_FT_ENABLE_STOPWORD = 'innodb_ft_enable_stopword';
    public const INNODB_FT_MAX_TOKEN_SIZE = 'innodb_ft_max_token_size';
    public const INNODB_FT_MIN_TOKEN_SIZE = 'innodb_ft_min_token_size';
    public const INNODB_FT_NUM_WORD_OPTIMIZE = 'innodb_ft_num_word_optimize';
    public const INNODB_FT_RESULT_CACHE_LIMIT = 'innodb_ft_result_cache_limit';
    public const INNODB_FT_SERVER_STOPWORD_TABLE = 'innodb_ft_server_stopword_table';
    public const INNODB_FT_SORT_PLL_DEGREE = 'innodb_ft_sort_pll_degree';
    public const INNODB_FT_TOTAL_CACHE_SIZE = 'innodb_ft_total_cache_size';
    public const INNODB_FT_USER_STOPWORD_TABLE = 'innodb_ft_user_stopword_table';
    public const INNODB_IO_CAPACITY = 'innodb_io_capacity';
    public const INNODB_IO_CAPACITY_MAX = 'innodb_io_capacity_max';
    public const INNODB_LARGE_PREFIX = 'innodb_large_prefix';
    public const INNODB_LOCK_WAIT_TIMEOUT = 'innodb_lock_wait_timeout';
    public const INNODB_LOCKS_UNSAFE_FOR_BINLOG = 'innodb_locks_unsafe_for_binlog';
    public const INNODB_LOG_BUFFER_SIZE = 'innodb_log_buffer_size';
    public const INNODB_LOG_CHECKSUMS = 'innodb_log_checksums';
    public const INNODB_LOG_COMPRESSED_PAGES = 'innodb_log_compressed_pages';
    public const INNODB_LOG_FILE_SIZE = 'innodb_log_file_size';
    public const INNODB_LOG_FILES_IN_GROUP = 'innodb_log_files_in_group';
    public const INNODB_LOG_GROUP_HOME_DIR = 'innodb_log_group_home_dir';
    public const INNODB_LOG_WRITE_AHEAD_SIZE = 'innodb_log_write_ahead_size';
    public const INNODB_LRU_SCAN_DEPTH = 'innodb_lru_scan_depth';
    public const INNODB_MAX_DIRTY_PAGES_PCT = 'innodb_max_dirty_pages_pct';
    public const INNODB_MAX_DIRTY_PAGES_PCT_LWM = 'innodb_max_dirty_pages_pct_lwm';
    public const INNODB_MAX_PURGE_LAG = 'innodb_max_purge_lag';
    public const INNODB_MAX_PURGE_LAG_DELAY = 'innodb_max_purge_lag_delay';
    public const INNODB_MAX_UNDO_LOG_SIZE = 'innodb_max_undo_log_size';
    public const INNODB_MONITOR_DISABLE = 'innodb_monitor_disable';
    public const INNODB_MONITOR_ENABLE = 'innodb_monitor_enable';
    public const INNODB_MONITOR_RESET = 'innodb_monitor_reset';
    public const INNODB_MONITOR_RESET_ALL = 'innodb_monitor_reset_all';
    public const INNODB_OLD_BLOCKS_PCT = 'innodb_old_blocks_pct';
    public const INNODB_OLD_BLOCKS_TIME = 'innodb_old_blocks_time';
    public const INNODB_ONLINE_ALTER_LOG_MAX_SIZE = 'innodb_online_alter_log_max_size';
    public const INNODB_OPEN_FILES = 'innodb_open_files';
    public const INNODB_OPTIMIZE_FULLTEXT_ONLY = 'innodb_optimize_fulltext_only';
    public const INNODB_PAGE_CLEANERS = 'innodb_page_cleaners'; // added in 5.7
    public const INNODB_PAGE_SIZE = 'innodb_page_size';
    public const INNODB_PRINT_ALL_DEADLOCKS = 'innodb_print_all_deadlocks';
    public const INNODB_PURGE_BATCH_SIZE = 'innodb_purge_batch_size';
    public const INNODB_PURGE_RSEG_TRUNCATE_FREQUENCY = 'innodb_purge_rseg_truncate_frequency';
    public const INNODB_PURGE_THREADS = 'innodb_purge_threads';
    public const INNODB_RANDOM_READ_AHEAD = 'innodb_random_read_ahead';
    public const INNODB_READ_AHEAD_THRESHOLD = 'innodb_read_ahead_threshold';
    public const INNODB_READ_IO_THREADS = 'innodb_read_io_threads';
    public const INNODB_READ_ONLY = 'innodb_read_only';
    public const INNODB_REDO_LOG_ENCRYPT = 'innodb_redo_log_encrypt';
    public const INNODB_REPLICATION_DELAY = 'innodb_replication_delay';
    public const INNODB_ROLLBACK_ON_TIMEOUT = 'innodb_rollback_on_timeout';
    public const INNODB_ROLLBACK_SEGMENTS = 'innodb_rollback_segments';
    public const INNODB_SORT_BUFFER_SIZE = 'innodb_sort_buffer_size';
    public const INNODB_SPIN_WAIT_DELAY = 'innodb_spin_wait_delay';
    public const INNODB_STATS_AUTO_RECALC = 'innodb_stats_auto_recalc';
    public const INNODB_STATS_METHOD = 'innodb_stats_method';
    public const INNODB_STATS_ON_METADATA = 'innodb_stats_on_metadata';
    public const INNODB_STATS_PERSISTENT = 'innodb_stats_persistent';
    public const INNODB_STATS_PERSISTENT_SAMPLE_PAGES = 'innodb_stats_persistent_sample_pages';
    public const INNODB_STATS_SAMPLE_PAGES = 'innodb_stats_sample_pages';
    public const INNODB_STATS_TRANSIENT_SAMPLE_PAGES = 'innodb_stats_transient_sample_pages';
    public const INNODB_STATUS_OUTPUT = 'innodb_status_output';
    public const INNODB_STATUS_OUTPUT_LOCKS = 'innodb_status_output_locks';
    public const INNODB_STRICT_MODE = 'innodb_strict_mode';
    public const INNODB_SUPPORT_XA = 'innodb_support_xa';
    public const INNODB_SYNC_ARRAY_SIZE = 'innodb_sync_array_size';
    public const INNODB_SYNC_SPIN_LOOPS = 'innodb_sync_spin_loops';
    public const INNODB_TABLE_LOCKS = 'innodb_table_locks';
    public const INNODB_TEMP_DATA_FILE_PATH = 'innodb_temp_data_file_path';
    public const INNODB_THREAD_CONCURRENCY = 'innodb_thread_concurrency';
    public const INNODB_THREAD_SLEEP_DELAY = 'innodb_thread_sleep_delay';
    public const INNODB_UNDO_DIRECTORY = 'innodb_undo_directory';
    public const INNODB_UNDO_LOG_ENCRYPT = 'innodb_undo_log_encrypt';
    public const INNODB_UNDO_LOG_TRUNCATE = 'innodb_undo_log_truncate';
    public const INNODB_UNDO_LOGS = 'innodb_undo_logs';
    public const INNODB_UNDO_TABLESPACES = 'innodb_undo_tablespaces';
    public const INNODB_USE_NATIVE_AIO = 'innodb_use_native_aio';
    public const INNODB_VERSION = 'innodb_version';
    public const INNODB_WRITE_IO_THREADS = 'innodb_write_io_threads';
    public const INSERT_ID = 'insert_id';
    public const INTERACTIVE_TIMEOUT = 'interactive_timeout';
    public const INTERNAL_TMP_DISK_STORAGE_ENGINE = 'internal_tmp_disk_storage_engine';
    public const JOIN_BUFFER_SIZE = 'join_buffer_size';
    public const KEEP_FILES_ON_CREATE = 'keep_files_on_create';
    public const KEY_BUFFER_SIZE = 'key_buffer_size';
    public const KEY_CACHE_AGE_THRESHOLD = 'key_cache_age_threshold';
    public const KEY_CACHE_BLOCK_SIZE = 'key_cache_block_size';
    public const KEY_CACHE_DIVISION_LIMIT = 'key_cache_division_limit';
    public const KEYRING_FILE_DATA = 'keyring_file_data';
    public const LARGE_FILES_SUPPORT = 'large_files_support';
    public const LARGE_PAGE_SIZE = 'large_page_size';
    public const LARGE_PAGES = 'large_pages';
    public const LAST_INSERT_ID = 'last_insert_id';
    public const LC_MESSAGES = 'lc_messages';
    public const LC_MESSAGES_DIR = 'lc_messages_dir';
    public const LC_TIME_NAMES = 'lc_time_names';
    public const LICENSE = 'license';
    public const LOCAL_INFILE = 'local_infile';
    public const LOCK_WAIT_TIMEOUT = 'lock_wait_timeout';
    public const LOG_BIN = 'log_bin';
    public const LOG_BIN_BASENAME = 'log_bin_basename';
    public const LOG_BIN_INDEX = 'log_bin_index';
    public const LOG_BIN_TRUST_FUNCTION_CREATORS = 'log_bin_trust_function_creators';
    public const LOG_BIN_USE_V1_ROW_EVENTS = 'log_bin_use_v1_row_events';
    public const LOG_BUILTIN_AS_IDENTIFIED_BY_PASSWORD = 'log_builtin_as_identified_by_password';
    public const LOG_ERROR = 'log_error';
    public const LOG_ERROR_VERBOSITY = 'log_error_verbosity';
    public const LOG_OUTPUT = 'log_output';
    public const LOG_QUERIES_NOT_USING_INDEXES = 'log_queries_not_using_indexes';
    public const LOG_SLAVE_UPDATES = 'log_slave_updates';
    public const LOG_SLOW_ADMIN_STATEMENTS = 'log_slow_admin_statements';
    public const LOG_SLOW_SLAVE_STATEMENTS = 'log_slow_slave_statements';
    public const LOG_STATEMENTS_UNSAFE_FOR_BINLOG = 'log_statements_unsafe_for_binlog';
    public const LOG_SYSLOG = 'log_syslog';
    public const LOG_SYSLOG_TAG = 'log_syslog_tag';
    public const LOG_THROTTLE_QUERIES_NOT_USING_INDEXES = 'log_throttle_queries_not_using_indexes';
    public const LOG_TIMESTAMPS = 'log_timestamps';
    public const LOG_WARNINGS = 'log_warnings';
    public const LONG_QUERY_TIME = 'long_query_time';
    public const LOW_PRIORITY_UPDATES = 'low_priority_updates';
    public const LOWER_CASE_FILE_SYSTEM = 'lower_case_file_system';
    public const LOWER_CASE_TABLE_NAMES = 'lower_case_table_names';
    public const MANDATORY_ROLES = 'mandatory_roles';
    public const MASTER_INFO_REPOSITORY = 'master_info_repository';
    public const MASTER_VERIFY_CHECKSUM = 'master_verify_checksum';
    public const MAX_ALLOWED_PACKET = 'max_allowed_packet';
    public const MAX_BINLOG_CACHE_SIZE = 'max_binlog_cache_size';
    public const MAX_BINLOG_SIZE = 'max_binlog_size';
    public const MAX_BINLOG_STMT_CACHE_SIZE = 'max_binlog_stmt_cache_size';
    public const MAX_CONNECT_ERRORS = 'max_connect_errors';
    public const MAX_CONNECTIONS = 'max_connections';
    public const MAX_DELAYED_THREADS = 'max_delayed_threads';
    public const MAX_DIGEST_LENGTH = 'max_digest_length';
    public const MAX_ERROR_COUNT = 'max_error_count';
    public const MAX_EXECUTION_TIME = 'max_execution_time';
    public const MAX_HEAP_TABLE_SIZE = 'max_heap_table_size';
    public const MAX_INSERT_DELAYED_THREADS = 'max_insert_delayed_threads';
    public const MAX_JOIN_SIZE = 'max_join_size';
    public const MAX_LENGTH_FOR_SORT_DATA = 'max_length_for_sort_data';
    public const MAX_POINTS_IN_GEOMETRY = 'max_points_in_geometry';
    public const MAX_PREPARED_STMT_COUNT = 'max_prepared_stmt_count';
    public const MAX_RELAY_LOG_SIZE = 'max_relay_log_size';
    public const MAX_SEEKS_FOR_KEY = 'max_seeks_for_key';
    public const MAX_SORT_LENGTH = 'max_sort_length';
    public const MAX_SP_RECURSION_DEPTH = 'max_sp_recursion_depth';
    public const MAX_TMP_TABLES = 'max_tmp_tables';
    public const MAX_USER_CONNECTIONS = 'max_user_connections';
    public const MAX_WRITE_LOCK_COUNT = 'max_write_lock_count';
    public const METADATA_LOCKS_CACHE_SIZE = 'metadata_locks_cache_size';
    public const METADATA_LOCKS_HASH_INSTANCES = 'metadata_locks_hash_instances';
    public const MIN_EXAMINED_ROW_LIMIT = 'min_examined_row_limit';
    public const MULTI_RANGE_COUNT = 'multi_range_count';
    public const MYISAM_DATA_POINTER_SIZE = 'myisam_data_pointer_size';
    public const MYISAM_MAX_SORT_FILE_SIZE = 'myisam_max_sort_file_size';
    public const MYISAM_MMAP_SIZE = 'myisam_mmap_size';
    public const MYISAM_RECOVER_OPTIONS = 'myisam_recover_options';
    public const MYISAM_REPAIR_THREADS = 'myisam_repair_threads';
    public const MYISAM_SORT_BUFFER_SIZE = 'myisam_sort_buffer_size';
    public const MYISAM_STATS_METHOD = 'myisam_stats_method';
    public const MYISAM_USE_MMAP = 'myisam_use_mmap';
    public const MYSQL_NATIVE_PASSWORD_PROXY_USERS = 'mysql_native_password_proxy_users';
    public const NAMED_PIPE = 'named_pipe';
    public const NET_BUFFER_LENGTH = 'net_buffer_length';
    public const NET_READ_TIMEOUT = 'net_read_timeout';
    public const NET_RETRY_COUNT = 'net_retry_count';
    public const NET_WRITE_TIMEOUT = 'net_write_timeout';
    public const NEW = 'new';
    public const NGRAM_TOKEN_SIZE = 'ngram_token_size';
    public const NULL_AUDIT_ABORT_MESSAGE = 'null_audit_abort_message';
    public const NULL_AUDIT_ABORT_VALUE = 'null_audit_abort_value';
    public const NULL_AUDIT_EVENT_ORDER_CHECK = 'null_audit_event_order_check';
    public const NULL_AUDIT_EVENT_ORDER_CHECK_CONSUME_IGNORE_COUNT = 'null_audit_event_order_check_consume_ignore_count';
    public const NULL_AUDIT_EVENT_ORDER_CHECK_EXACT = 'null_audit_event_order_check_exact';
    public const NULL_AUDIT_EVENT_ORDER_STARTED = 'null_audit_event_order_started';
    public const NULL_AUDIT_EVENT_RECORD = 'null_audit_event_record';
    public const NULL_AUDIT_EVENT_RECORD_DEF = 'null_audit_event_record_def';
    public const OFFLINE_MODE = 'offline_mode';
    public const OLD = 'old';
    public const OLD_ALTER_TABLE = 'old_alter_table';
    public const OLD_PASSWORDS = 'old_passwords';
    public const OPEN_FILES_LIMIT = 'open_files_limit';
    public const OPTIMIZER_PRUNE_LEVEL = 'optimizer_prune_level';
    public const OPTIMIZER_SEARCH_DEPTH = 'optimizer_search_depth';
    public const OPTIMIZER_SWITCH = 'optimizer_switch'; // new in 5.7Mes
    public const OPTIMIZER_TRACE = 'optimizer_trace';
    public const OPTIMIZER_TRACE_FEATURES = 'optimizer_trace_features';
    public const OPTIMIZER_TRACE_LIMIT = 'optimizer_trace_limit';
    public const OPTIMIZER_TRACE_MAX_MEM_SIZE = 'optimizer_trace_max_mem_size';
    public const OPTIMIZER_TRACE_OFFSET = 'optimizer_trace_offset';
    public const PARTIAL_REVOKES = 'partial_revokes';
    public const PASSWORD_REQUIRE_CURRENT = 'password_require_current';
    public const PERFORMANCE_SCHEMA = 'performance_schema';
    public const PERFORMANCE_SCHEMA_ACCOUNTS_SIZE = 'performance_schema_accounts_size';
    public const PERFORMANCE_SCHEMA_DIGESTS_SIZE = 'performance_schema_digests_size';
    public const PERFORMANCE_SCHEMA_EVENTS_STAGES_HISTORY_LONG_SIZE = 'performance_schema_events_stages_history_long_size';
    public const PERFORMANCE_SCHEMA_EVENTS_STAGES_HISTORY_SIZE = 'performance_schema_events_stages_history_size';
    public const PERFORMANCE_SCHEMA_EVENTS_STATEMENTS_HISTORY_LONG_SIZE = 'performance_schema_events_statements_history_long_size';
    public const PERFORMANCE_SCHEMA_EVENTS_STATEMENTS_HISTORY_SIZE = 'performance_schema_events_statements_history_size';
    public const PERFORMANCE_SCHEMA_EVENTS_TRANSACTIONS_HISTORY_LONG_SIZE = 'performance_schema_events_transactions_history_long_size';
    public const PERFORMANCE_SCHEMA_EVENTS_TRANSACTIONS_HISTORY_SIZE = 'performance_schema_events_transactions_history_size';
    public const PERFORMANCE_SCHEMA_EVENTS_WAITS_HISTORY_LONG_SIZE = 'performance_schema_events_waits_history_long_size';
    public const PERFORMANCE_SCHEMA_EVENTS_WAITS_HISTORY_SIZE = 'performance_schema_events_waits_history_size';
    public const PERFORMANCE_SCHEMA_HOSTS_SIZE = 'performance_schema_hosts_size';
    public const PERFORMANCE_SCHEMA_MAX_COND_CLASSES = 'performance_schema_max_cond_classes';
    public const PERFORMANCE_SCHEMA_MAX_COND_INSTANCES = 'performance_schema_max_cond_instances';
    public const PERFORMANCE_SCHEMA_MAX_DIGEST_LENGTH = 'performance_schema_max_digest_length';
    public const PERFORMANCE_SCHEMA_MAX_FILE_CLASSES = 'performance_schema_max_file_classes';
    public const PERFORMANCE_SCHEMA_MAX_FILE_HANDLES = 'performance_schema_max_file_handles';
    public const PERFORMANCE_SCHEMA_MAX_FILE_INSTANCES = 'performance_schema_max_file_instances';
    public const PERFORMANCE_SCHEMA_MAX_INDEX_STAT = 'performance_schema_max_index_stat';
    public const PERFORMANCE_SCHEMA_MAX_MEMORY_CLASSES = 'performance_schema_max_memory_classes';
    public const PERFORMANCE_SCHEMA_MAX_METADATA_LOCKS = 'performance_schema_max_metadata_locks';
    public const PERFORMANCE_SCHEMA_MAX_MUTEX_CLASSES = 'performance_schema_max_mutex_classes';
    public const PERFORMANCE_SCHEMA_MAX_MUTEX_INSTANCES = 'performance_schema_max_mutex_instances';
    public const PERFORMANCE_SCHEMA_MAX_PREPARED_STATEMENTS_INSTANCES = 'performance_schema_max_prepared_statements_instances';
    public const PERFORMANCE_SCHEMA_MAX_PROGRAM_INSTANCES = 'performance_schema_max_program_instances';
    public const PERFORMANCE_SCHEMA_MAX_RWLOCK_CLASSES = 'performance_schema_max_rwlock_classes';
    public const PERFORMANCE_SCHEMA_MAX_RWLOCK_INSTANCES = 'performance_schema_max_rwlock_instances';
    public const PERFORMANCE_SCHEMA_MAX_SOCKET_CLASSES = 'performance_schema_max_socket_classes';
    public const PERFORMANCE_SCHEMA_MAX_SOCKET_INSTANCES = 'performance_schema_max_socket_instances';
    public const PERFORMANCE_SCHEMA_MAX_SQL_TEXT_LENGTH = 'performance_schema_max_sql_text_length';
    public const PERFORMANCE_SCHEMA_MAX_STAGE_CLASSES = 'performance_schema_max_stage_classes';
    public const PERFORMANCE_SCHEMA_MAX_STATEMENT_CLASSES = 'performance_schema_max_statement_classes';
    public const PERFORMANCE_SCHEMA_MAX_STATEMENT_STACK = 'performance_schema_max_statement_stack';
    public const PERFORMANCE_SCHEMA_MAX_TABLE_HANDLES = 'performance_schema_max_table_handles';
    public const PERFORMANCE_SCHEMA_MAX_TABLE_INSTANCES = 'performance_schema_max_table_instances';
    public const PERFORMANCE_SCHEMA_MAX_TABLE_LOCK_STAT = 'performance_schema_max_table_lock_stat';
    public const PERFORMANCE_SCHEMA_MAX_THREAD_CLASSES = 'performance_schema_max_thread_classes';
    public const PERFORMANCE_SCHEMA_MAX_THREAD_INSTANCES = 'performance_schema_max_thread_instances';
    public const PERFORMANCE_SCHEMA_SESSION_CONNECT_ATTRS_SIZE = 'performance_schema_session_connect_attrs_size';
    public const PERFORMANCE_SCHEMA_SETUP_ACTORS_SIZE = 'performance_schema_setup_actors_size';
    public const PERFORMANCE_SCHEMA_SETUP_OBJECTS_SIZE = 'performance_schema_setup_objects_size';
    public const PERFORMANCE_SCHEMA_USERS_SIZE = 'performance_schema_users_size';
    public const PID_FILE = 'pid_file';
    public const PLUGIN_DIR = 'plugin_dir';
    public const PORT = 'port';
    public const PRELOAD_BUFFER_SIZE = 'preload_buffer_size';
    public const PROFILING = 'profiling';
    public const PROFILING_HISTORY_SIZE = 'profiling_history_size';
    public const PROTOCOL_VERSION = 'protocol_version';
    public const PROXY_USER = 'proxy_user';
    public const PSEUDO_REPLICA_MODE = 'pseudo_replica_mode';
    public const PSEUDO_SLAVE_MODE = 'pseudo_slave_mode';
    public const PSEUDO_THREAD_ID = 'pseudo_thread_id';
    public const QUERY_ALLOC_BLOCK_SIZE = 'query_alloc_block_size';
    public const QUERY_CACHE_LIMIT = 'query_cache_limit';
    public const QUERY_CACHE_MIN_RES_UNIT = 'query_cache_min_res_unit';
    public const QUERY_CACHE_SIZE = 'query_cache_size';
    public const QUERY_CACHE_TYPE = 'query_cache_type';
    public const QUERY_CACHE_WLOCK_INVALIDATE = 'query_cache_wlock_invalidate';
    public const QUERY_PREALLOC_SIZE = 'query_prealloc_size';
    public const RAND_SEED1 = 'rand_seed1';
    public const RAND_SEED2 = 'rand_seed2';
    public const RANGE_ALLOC_BLOCK_SIZE = 'range_alloc_block_size';
    public const RANGE_OPTIMIZER_MAX_MEM_SIZE = 'range_optimizer_max_mem_size';
    public const RBR_EXEC_MODE = 'rbr_exec_mode';
    public const READ_BUFFER_SIZE = 'read_buffer_size';
    public const READ_ONLY = 'read_only';
    public const READ_RND_BUFFER_SIZE = 'read_rnd_buffer_size';
    public const RELAY_LOG = 'relay_log';
    public const RELAY_LOG_BASENAME = 'relay_log_basename';
    public const RELAY_LOG_INDEX = 'relay_log_index';
    public const RELAY_LOG_INFO_FILE = 'relay_log_info_file';
    public const RELAY_LOG_INFO_REPOSITORY = 'relay_log_info_repository';
    public const RELAY_LOG_PURGE = 'relay_log_purge';
    public const RELAY_LOG_RECOVERY = 'relay_log_recovery';
    public const RELAY_LOG_SPACE_LIMIT = 'relay_log_space_limit';
    public const REPLICA_EXEC_MODE = 'replica_exec_mode';
    public const REPLICA_PARALLEL_TYPE = 'replica_parallel_type';
    public const REPLICA_PARALLEL_WORKERS = 'replica_parallel_workers';
    public const REPLICA_PRESERVE_COMMIT_ORDER = 'replica_preserve_commit_order';
    public const REPLICA_TRANSACTION_RETRIES = 'replica_transaction_retries';
    public const REPLICA_TYPE_CONVERSIONS = 'replica_type_conversions';
    public const REPORT_HOST = 'report_host';
    public const REPORT_PASSWORD = 'report_password';
    public const REPORT_PORT = 'report_port';
    public const REPORT_USER = 'report_user';
    public const REQUIRE_SECURE_TRANSPORT = 'require_secure_transport';
    public const RPL_SEMI_SYNC_SOURCE_WAIT_POINT = 'rpl_semi_sync_source_wait_point';
    public const RPL_STOP_SLAVE_TIMEOUT = 'rpl_stop_slave_timeout';
    public const SECURE_AUTH = 'secure_auth';
    public const SECURE_FILE_PRIV = 'secure_file_priv';
    public const SERVER_ID = 'server_id';
    public const SERVER_ID_BITS = 'server_id_bits';
    public const SERVER_UUID = 'server_uuid';
    public const SESSION_TRACK_GTIDS = 'session_track_gtids';
    public const SESSION_TRACK_SCHEMA = 'session_track_schema';
    public const SESSION_TRACK_STATE_CHANGE = 'session_track_state_change';
    public const SESSION_TRACK_SYSTEM_VARIABLES = 'session_track_system_variables';
    public const SESSION_TRACK_TRANSACTION_INFO = 'session_track_transaction_info';
    public const SHA256_PASSWORD_PROXY_USERS = 'sha256_password_proxy_users';
    public const SHARED_MEMORY = 'shared_memory';
    public const SHARED_MEMORY_BASE_NAME = 'shared_memory_base_name';
    public const SHOW_COMPATIBILITY_56 = 'show_compatibility_56'; // removed in 8.0
    public const SHOW_OLD_TEMPORALS = 'show_old_temporals';
    public const SKIP_EXTERNAL_LOCKING = 'skip_external_locking';
    public const SKIP_NAME_RESOLVE = 'skip_name_resolve';
    public const SKIP_NETWORKING = 'skip_networking';
    public const SKIP_SHOW_DATABASE = 'skip_show_database';
    public const SLAVE_ALLOW_BATCHING = 'slave_allow_batching';
    public const SLAVE_CHECKPOINT_GROUP = 'slave_checkpoint_group';
    public const SLAVE_CHECKPOINT_PERIOD = 'slave_checkpoint_period';
    public const SLAVE_COMPRESSED_PROTOCOL = 'slave_compressed_protocol';
    public const SLAVE_EXEC_MODE = 'slave_exec_mode';
    public const SLAVE_LOAD_TMPDIR = 'slave_load_tmpdir';
    public const SLAVE_MAX_ALLOWED_PACKET = 'slave_max_allowed_packet';
    public const SLAVE_NET_TIMEOUT = 'slave_net_timeout';
    public const SLAVE_PARALLEL_TYPE = 'slave_parallel_type';
    public const SLAVE_PARALLEL_WORKERS = 'slave_parallel_workers';
    public const SLAVE_PENDING_JOBS_SIZE_MAX = 'slave_pending_jobs_size_max';
    public const SLAVE_PRESERVE_COMMIT_ORDER = 'slave_preserve_commit_order';
    public const SLAVE_ROWS_SEARCH_ALGORITHMS = 'slave_rows_search_algorithms';
    public const SLAVE_SKIP_ERRORS = 'slave_skip_errors';
    public const SLAVE_SQL_VERIFY_CHECKSUM = 'slave_sql_verify_checksum';
    public const SLAVE_TRANSACTION_RETRIES = 'slave_transaction_retries';
    public const SLAVE_TYPE_CONVERSIONS = 'slave_type_conversions';
    public const SLOW_LAUNCH_TIME = 'slow_launch_time';
    public const SLOW_QUERY_LOG = 'slow_query_log';
    public const SLOW_QUERY_LOG_FILE = 'slow_query_log_file';
    public const SOCKET = 'socket';
    public const SORT_BUFFER_SIZE = 'sort_buffer_size';
    public const SOURCE_VERIFY_CHECKSUM = 'source_verify_checksum';
    public const SQL_AUTO_IS_NULL = 'sql_auto_is_null';
    public const SQL_BIG_SELECTS = 'sql_big_selects';
    public const SQL_BUFFER_RESULT = 'sql_buffer_result';
    public const SQL_LOG_BIN = 'sql_log_bin';
    public const SQL_LOG_OFF = 'sql_log_off';
    public const SQL_MODE = 'sql_mode';
    public const SQL_NOTES = 'sql_notes';
    public const SQL_QUOTE_SHOW_CREATE = 'sql_quote_show_create';
    public const SQL_REPLICA_SKIP_COUNTER = 'sql_replica_skip_counter';
    public const SQL_REQUIRE_PRIMARY_KEY = 'sql_require_primary_key';
    public const SQL_SAFE_UPDATES = 'sql_safe_updates';
    public const SQL_SELECT_LIMIT = 'sql_select_limit';
    public const SQL_SLAVE_SKIP_COUNTER = 'sql_slave_skip_counter';
    public const SQL_WARNINGS = 'sql_warnings';
    public const SSL_CA = 'ssl_ca';
    public const SSL_CAPATH = 'ssl_capath';
    public const SSL_CERT = 'ssl_cert';
    public const SSL_CIPHER = 'ssl_cipher';
    public const SSL_CRL = 'ssl_crl';
    public const SSL_CRLPATH = 'ssl_crlpath';
    public const SSL_KEY = 'ssl_key';
    public const STORED_PROGRAM_CACHE = 'stored_program_cache';
    public const SUPER_READ_ONLY = 'super_read_only';
    public const SYNC_BINLOG = 'sync_binlog';
    public const SYNC_FRM = 'sync_frm'; // removed in 8.0
    public const SYNC_MASTER_INFO = 'sync_master_info';
    public const SYNC_RELAY_LOG = 'sync_relay_log';
    public const SYNC_RELAY_LOG_INFO = 'sync_relay_log_info';
    public const SYSTEM_TIME_ZONE = 'system_time_zone';
    public const TABLE_DEFINITION_CACHE = 'table_definition_cache';
    public const TABLE_OPEN_CACHE = 'table_open_cache';
    public const TABLE_OPEN_CACHE_INSTANCES = 'table_open_cache_instances';
    public const THREAD_CACHE_SIZE = 'thread_cache_size';
    public const THREAD_HANDLING = 'thread_handling';
    public const THREAD_STACK = 'thread_stack';
    public const TIME_FORMAT = 'time_format';
    public const TIME_ZONE = 'time_zone';
    public const TIMESTAMP = 'timestamp';
    public const TLS_VERSION = 'tls_version';
    public const TMP_TABLE_SIZE = 'tmp_table_size';
    public const TMPDIR = 'tmpdir';
    public const TRANSACTION_ALLOC_BLOCK_SIZE = 'transaction_alloc_block_size';
    public const TRANSACTION_ALLOW_BATCHING = 'transaction_allow_batching';
    public const TRANSACTION_ISOLATION = 'transaction_isolation';
    public const TRANSACTION_PREALLOC_SIZE = 'transaction_prealloc_size';
    public const TRANSACTION_WRITE_SET_EXTRACTION = 'transaction_write_set_extraction';
    public const TX_ISOLATION = 'tx_isolation';
    public const TX_READ_ONLY = 'tx_read_only';
    public const UNIQUE_CHECKS = 'unique_checks';
    public const UPDATABLE_VIEWS_WITH_LIMIT = 'updatable_views_with_limit';
    public const VERSION = 'version';
    public const VERSION_COMMENT = 'version_comment';
    public const VERSION_COMPILE_MACHINE = 'version_compile_machine';
    public const VERSION_COMPILE_OS = 'version_compile_os';
    public const WAIT_TIMEOUT = 'wait_timeout';
    public const WARNING_COUNT = 'warning_count';

}
