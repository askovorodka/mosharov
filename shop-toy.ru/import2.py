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
        and c.id = %d limit 1 ''' % ((int(param_level)-1), db.escape(str(name)), int(param_level), int(parent))
        #print sql.encode('utf-8')
    else:
        sql = ''' select a.* from fw_catalogue as a 
        where a.name = '%s' and a.param_level = '%d' limit 1 ''' % (db.escape(str(name)), int(param_level))
    
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

if imported_rows == None:
    print "Импортировать нечего"
    sys.exit()

#находим корневую категорию
rootcat = get_category(1)

for row in imported_rows:
    #находим привязку категории из прайса к каталогу
    cat1 = db.selectrow("select * from matches_category2 where group_prod = '%s'" % str(row['group_prod']))
    if cat1 == None:
        continue
    else:
        cat_param_1 = db.selectrow("select * from fw_catalogue where id='%d'" % int(cat1['cat_id']))
    
    if cat_param_1 == None:
        continue
    
    #находим категорию в каталоге, если нет, то добавляем
    cat_param_2 = search_category(cat1['group_prod_change'], 2, int(cat_param_1['id']))
    #если нет категории, добавлем ее
    if cat_param_2 == None:
        cat2_id = insert(cat_param_1)
        url = 'category' + str(cat2_id)
        status = 1
        db.query("update fw_catalogue set name = '%s', url = '%s', status = '%d' where id='%d' " % (db.escape(str(cat1['group_prod'])), url, status, cat2_id))
        cat_param_2 = get_category(cat2_id)
        print "Добавлена категория: %s" % str(cat1['group_prod'])
    
    #находим продукт, если его нет, то добавляем, иначе обновляем
    product = search_product(cat_param_2['id'], row['article'])
    if (product == None):
        db.query("insert into fw_products (parent, name, article, price, status) values ('%d', '%s', '%s', '%f', '1')" % (int(cat_param_2['id']), db.escape(str(row['nomen'])), str(row['article']), float(row['price'])))
        product_id = int(last_insert_id())
        db.query("replace into _import_product_links (product_id, product_from) values('%d', '%s')" % (product_id, str(row['image'])))
        print "Добавлен продукт: %s" % str(row['nomen']) 
    else:
        db.query("update fw_products set price = '%f' where id = '%d'" % (float(row['price']), int(product['id'])))
        print "Обновлен продукт: %s" % str(row['nomen'])
    
db.query("truncate _imported_rows")
db.query("update fw_conf set conf_value = '0' where conf_key = 'IMPORT_METKA' ")
print "Очищена таблица _imported_rows, обнулена константа IMPORT_METKA"
print "Импорт завершен"

print "Запустить парсер ? (1-да)"
a = sys.stdin.readline()
if int(a) == 1:
    cmd = "/usr/local/bin/python /home/alex/data/www/shop-toy.mosharov.com/grab_parser.py"
    os.system(cmd)


#print "Для запуска парсера, набрать: /usr/local/bin/python /home/alex/data/www/shop-toy.mosharov.com/grab_parser.py"
db.close()
