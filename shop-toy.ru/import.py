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


#xls = xlrd.open_workbook(root + "/price.xls", on_demand=True,formatting_info=False,encoding_override="cp1251")
xls = xlrd.open_workbook(root + "/price.xls", encoding_override="cp1251")
sheet = xls.sheet_by_index(0)

#num_of_rows = sheet.nrows
#num_of_cols = sheet.ncols
#for i in range(num_of_rows):
#    if i > 3:
#        for j in range(num_of_cols):
#            data = sheet.cell(i,j).value
#            print "столбец %d, данные %s" % (j, data.encode('utf-8'))

#sys.exit()

for rownum in range(sheet.nrows):
    row = sheet.row_values(rownum)
    if (rownum > 3):
        #code = str(row[1].encode('cp1251'))
        #code = code.replace(",", ".")
        #code = float(code)
        code = float(row[1])
        article = row[3].encode('cp1251')
        nom = str(row[4].encode('cp1251'))
        group = str(row[5].encode('cp1251'))
        metka = str(row[6].encode('cp1251'))
        price = str(row[7]).encode('cp1251')
        price = price.replace(",", "")
        price = float(price)
        ed = str(row[8].encode('cp1251'))
        pack = float(row[9])
        image = str(row[10].encode('cp1251'))
        ostatok = float(row[11])
    
    continue

    for cell in row:
        if rownum == 4:
            code = float(row[1])
            article = str(row[2].encode('cp1251'))
            nom = str(row[3].encode('cp1251'))
            group = str(row[4].encode('cp1251'))
            metka = str(row[5].encode('cp1251'))
            price = float(row[6])
            ed = str(row[7].encode('cp1251'))
            pack = float(row[8])
            image = str(row[9].encode('cp1251'))
            ostatok = flost(row[10])
