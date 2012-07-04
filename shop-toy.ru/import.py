#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import xlrd
import os
import sys

import DataBase

DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")

imported_rows = db.select("select * from _imported_rows")

if len(imported_rows) == 0:
    print "Импорт не актуален"
    sys.exit()

for row in imported_rows:
    #находим соответствие категории уровня 1
    cat1 = db.selectrow("select * from matches_category where name_feed='%s' and param_level=%d" % (db.escape(str(row['group_prod'])), 2))
    if (cat1 == None):
        db.query("insert into matches_category (name_feed, name_db, param_level) values ('%s', '%s', '%d')" % (db.escape(str(row['group_prod'])), db.escape(str(row['group_prod'])), 2))
        cat1_name_db = row['group_prod']
    else:
        cat1_name_db = str(cat1['name_db'])
        
    #находим соответствие категории уровня 2
    print row['nomen']
    cat2 = db.selectrow("select * from matches_category where name_feed='%s' and param_level=%d" % (db.escape(str(row['nomen'])), 3))
    if (cat2 == None):
        db.query("insert into matches_category (name_feed, name_db, param_level) values ('%s', '%s', '%d')" % (db.escape(str(row['nomen'])), db.escape(str(row['nomen'])), 3))
        cat2_name_db = row['nomen']
    else:
        cat2_name_db = str(cat2['name_db'])
    

db.close()
