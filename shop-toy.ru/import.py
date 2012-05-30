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
#xls = xlrd.open_workbook(root + "/price.xls", on_demand=True,formatting_info=False,encoding_override="cp1251")
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
        price = float(price)
        ed = unicode(row[8]).encode('cp1251')
        pack = float(row[9])
        image = unicode(row[10]).encode('cp1251')
        ostatok = float(row[11])
        
        db.query('''insert into _imported_rows(code, article, nomen,group_prod, metka, price, ed, pack, image,ost) 
        values('%s','%s', '%s', '%s', '%s', '%f', '%s', '%f', '%s', '%f')''' % (db.escape(code), db.escape(article), db.escape(nom), db.escape(group),db.escape(metka),price,db.escape(ed),pack,db.escape(image),ostatok))

print "Сделано"
db.close()