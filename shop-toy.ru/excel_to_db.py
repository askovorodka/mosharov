#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import xlrd
import os
import sys

import DataBase

class Path:
    u'Определение абсолютного пути'
    __path = ""
    def __init__(self):
        self.__path = os.path.abspath(os.path.dirname(__file__)) 
    def get_path(self):
        return self.__path


DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
path = Path()
root = path.get_path()
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")

conf = db.selectrow("select conf_value from fw_conf where conf_key='XLS_UPDATE'")

if (conf == None or int(conf['conf_value']) == 0):
    print "Импорт не требуется"
    sys.exit()

xls = xlrd.open_workbook(root + "/price.xls", encoding_override="cp1251")
sheet = xls.sheet_by_index(0)

for rownum in range(sheet.nrows):
    row = sheet.row_values(rownum)
    if (rownum > 3):
        code = unicode(row[1]).encode('cp1251')
        article = unicode(row[3]).encode('cp1251')
        nom = unicode(row[4]).encode('cp1251')
        group = unicode(row[5]).encode('cp1251')
        metka = unicode(row[6]).encode('cp1251')
        price = unicode(row[7]).encode('cp1251')
        price = price.replace(",", "")
        #print price
        if price == None or price == "":
            price = 0.00
        else:
            price = float(price)
        ed = unicode(row[8]).encode('cp1251')
        pack = float(row[9])
        image = unicode(row[10]).encode('cp1251')
        ostatok = float(row[11])
        
        db.query('''insert into _imported_rows(code, article, nomen,group_prod, metka, price, ed, pack, image,ost) 
        values('%s','%s', '%s', '%s', '%s', '%f', '%s', '%f', '%s', '%f')''' % (db.escape(code), db.escape(article), db.escape(nom), db.escape(group),db.escape(metka),price,db.escape(ed),pack,db.escape(image),ostatok))
        
        print "Добавлена строка %d" % int(rownum)
        
        category = db.selectrow("select * from matches_category2 where group_prod = '%s'" % db.escape(group))
        if category == None:
            db.query("replace into categories_non_related (name) values('%s')" % db.escape(group))
            print "Добавлена новая неопределенная категория"

print "Сделано"
db.query("update fw_conf set conf_value = '0' where conf_key = 'XLS_UPDATE' ")
db.query("update fw_conf set conf_value = '1' where conf_key = 'IMPORT_METKA' ")
#print "Старт скрипта импорта..."
#cmd = "/usr/local/bin/python /home/alex/data/www/shop-toy.mosharov.com/import2.py"
#os.system(cmd)

db.close()