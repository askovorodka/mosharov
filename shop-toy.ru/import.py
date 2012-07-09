#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import xlrd
import os
import sys

import DataBase

DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")

def search_product(parent_id, article):
    query = "select * from fw_products where parent = '%d' and article = '%s'" % (int(parent_id), str(article))
    row = db.selectrow(query)
    if (row == None):
        return
    else:
        return row

def search_category(name, param_level, parent = None):
    if parent != None:
        sql = ''' select a.*, c.id from fw_catalogue as a 
        left join fw_catalogue as b on b.param_left <= a.param_left 
        and b.param_right >= a.param_right and b.param_level = 1
        left join fw_catalogue as c on c.param_left < a.param_left and c.param_right > a.param_right and c.param_level = %d
        where a.name = '%s' and a.param_level = '%d' 
        and c.id = %d ''' % ((int(param_level)-1), db.escape(str(name)), int(param_level), int(parent))
    else:
        sql = ''' select a.* from fw_catalogue as a 
        where a.name = '%s' and a.param_level = '%d' ''' % (db.escape(str(name)), int(param_level))
    
    result = db.selectrow(sql)
    if (result == None):
        return
    else:
        return result

def get_category(id):
    sql = "select * from fw_catalogue where id = '%d'" % int(id)
    result = db.selectrow(sql)
    if result != None:
    	return result
    else:
    	return

def last_insert_id():
    result = db.selectrow("select last_insert_id()")
    return result['last_insert_id()']



def insert(category):
    param_left = category['param_left']
    param_right = category['param_right']
    param_level = category['param_level']
    new_param_right = int(param_right) + 1
    new_param_level = int(param_level) + 1
    sql = ''' UPDATE fw_catalogue SET 
        param_left = IF(param_left> %d, param_left+2,param_left),
        param_right = IF(param_right >= %d,param_right+2,param_right) 
        WHERE param_right >= %d''' % (int(param_right), int(param_right), int(param_right))
        
    db.query(sql)
    sql = "insert into fw_catalogue (param_left, param_right, param_level) values (%d, %d, %d)" % (int(param_right), new_param_right, new_param_level)
    db.query(sql)
    return int(last_insert_id())

imported_rows = db.select("select * from _imported_rows")



if len(imported_rows) == 0:
    print "Импорт не актуален"
    sys.exit()

#находим корневую категорию каталога
rootcat = get_category(1)

for row in imported_rows:
    #находим соответствие категории уровня 1
    cat1 = db.selectrow("select * from matches_category where name_feed='%s' and param_level=%d" % (db.escape(str(row['group_prod'])), 1))
    
    if (cat1 == None):
        db.query("insert into matches_category (name_feed, name_db, param_level) values ('%s', '%s', '%d')" % (db.escape(str(row['group_prod'])), db.escape(str(row['group_prod'])), 1))
        cat1_name_db = str(row['group_prod'])
    else:
        cat1_name_db = str(cat1['name_db'])
    
    #находим соответствие категории уровня 2
    cat2 = db.selectrow("select * from matches_category where name_feed='%s' and param_level=%d" % (db.escape(str(row['nomen'])), 2))
    if (cat2 == None):
        db.query("insert into matches_category (name_feed, name_db, param_level) values ('%s', '%s', '%d')" % (db.escape(str(row['nomen'])), db.escape(str(row['nomen'])), 2))
        cat2_name_db = row['nomen']
    else:
        cat2_name_db = str(cat2['name_db'])
        
    #далее находим такую категорию, если ее нету, то добавляем
    brand = search_category(cat1_name_db, 1)
    
    if brand == None:
    	brand_id = insert(rootcat)
    	status = 1
    else:
    	brand_id = int(brand['id'])
    	status = int(brand['status'])
    
    brand_url = "brand" + str(brand_id)
    db.query("update fw_catalogue set name = '%s', url = '%s', status = '%d' where id='%d' " % (db.escape(str(cat1_name_db)), brand_url, status, brand_id))
    
    
    model = search_category(cat2_name_db, 2, brand_id)
    if model == None:
    	model_id = insert(brand)
    	status = 1
    else:
    	model_id = int(model['id'])
    	status = int(model['status'])
    model_url = "model" + str(model_id)
    db.query("update fw_catalogue set name = '%s', url = '%s', status = '%d' where id='%d' " % (db.escape(str(cat2_name_db)), model_url, status, model_id))
    
    

db.close()
