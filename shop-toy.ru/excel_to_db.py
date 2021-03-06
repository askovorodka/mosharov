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
    if (rownum > 0):

        code = unicode(row[0]).encode('cp1251','ignore')
        article = unicode(row[1]).encode('cp1251','ignore')
        nom = unicode(row[2]).encode('cp1251','ignore')
        group = unicode(row[3]).encode('cp1251','ignore')
        brand = unicode(row[4]).encode('cp1251','ignore')
        metka = unicode(row[5]).encode('cp1251','ignore')
        price = str(unicode(row[6]).encode('cp1251'))

        price = price.replace(",", "")
        article = article.replace(".0","")
        code = code.replace(".0","")

        try:
            if price == None or price == "":
                price = 0.00
            else:
                price = float(price)
        except ValueError:
            print "Ошибка перевода в числовой формат цену."
        ed = unicode(row[7]).encode('cp1251','ignore')
        
        if row[8] != None and row[8] != "":
            pack = float(row[8])
        else:
            pack = 0.00
        
        image = unicode(row[9]).encode('cp1251','ignore')
        ostatok = float(row[10])
        
        db.query('''insert into _imported_rows(code, article, nomen,group_prod,brand, metka, price, ed, pack, image,ost) 
        values('%s','%s', '%s', '%s', '%s','%s', '%f', '%s', '%f', '%s', '%f')''' % (db.escape(code), article, db.escape(nom), db.escape(group), db.escape(brand),db.escape(metka),price,db.escape(ed),pack,db.escape(image),ostatok))
        
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