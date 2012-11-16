#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import xlrd
import os
import sys
import re

import DataBase
import trans
import re
from urllib import urlencode

DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")



#item = db.selectrow("select * from fw_conf where conf_key='EXCLUDE_IMPORTED_WORDS'")
#items = item['conf_value'].split()
#for i in items:
#    print i

cats = db.select("select * from fw_catalogue where param_level=2")

for item in cats:
    
    name = item['name'].decode('cp1251')
    name = re.sub(", ", "_", name)
    name = re.sub("\s","_",name)
    url = name.encode('trans').lower().encode('cp1251')
    db.query("update fw_catalogue set url='%s' where id='%d'" % (str(url), int(item['id'])))
    
    
    
    #image = db.selectrow("select * from product_images where product_id=%d order by id desc limit 1" % int(item['id']))
    #if image != None:
    #    db.query("delete from product_images where product_id=%d and id<>%d" % (int(item['id']), int(image['id'])))
    
    #var = item['name'].decode('cp1251')
    #var = var.lower()
    #var1 = var[0].upper()
    #var2 = var[1:]
    #print"%s - %s " % (var.encode('utf-8'), (var1+var2).encode('utf-8'))
    
    #name = re.findall("\((.*?)\)", item['name'].decode('cp1251').encode('utf-8'))
    #print "%s - %s" % (item['name'], name)
    
    #name = re.sub("\((.*?)\)", "", item['name'].decode('cp1251').encode('utf-8'))
    #print "%s - %s" % (item['name'].decode('cp1251').encode('utf-8'), name.lower())
