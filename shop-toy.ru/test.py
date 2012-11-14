#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import xlrd
import os
import sys
import re

import DataBase

DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")



item = db.selectrow("select * from fw_conf where conf_key='EXCLUDE_IMPORTED_WORDS'")
items = item['conf_value'].split()
for i in items:
    print i

#for item in products:
    
    #name = re.findall("\((.*?)\)", item['name'].decode('cp1251').encode('utf-8'))
    #print "%s - %s" % (item['name'], name)
    
    #name = re.sub("\((.*?)\)", "", item['name'].decode('cp1251').encode('utf-8'))
    #print "%s - %s" % (item['name'].decode('cp1251').encode('utf-8'), name.lower())
