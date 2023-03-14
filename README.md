# HW9-SQL-Database

http://localhost:8000/test.php?insert=0 - insert test with innodb_flush_log_at_trx_commit = 0

http://localhost:8000/test.php?insert=1 - insert test with innodb_flush_log_at_trx_commit = 1

http://localhost:8000/test.php?insert=2 - insert test with innodb_flush_log_at_trx_commit = 2

http://localhost:8000/test.php - test with exact search on index

http://localhost:8000/test.php?range=1 - test with range search on index

http://localhost:8000/test.php?noindex=1 - test with exact search on noindex

http://localhost:8000/test.php?range=1&noindex=1 - test with range search on noindex

http://localhost:8000/test.php?hash=true - turn on innodb_adaptive_hash_index

http://localhost:8000/test.php?hash=false - turn off innodb_adaptive_hash_index