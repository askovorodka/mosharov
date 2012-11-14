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



#item = db.selectrow("select * from fw_conf where conf_key='EXCLUDE_IMPORTED_WORDS'")
#items = item['conf_value'].split()
#for i in items:
#    print i

products = db.select("select * from fw_products where (select count(*) from product_images where product_images.product_id=fw_products.id)>1")

for item in products:
    
    image = db.selectrow("select * from product_images where product_id=%d order by id desc limit 1" % int(item['id']))
    if image != None:
        db.query("delete from product_images where product_id=%d and id<>%d" % (int(item['id']), int(image['id'])))
    
    #var = item['name'].decode('cp1251')
    #var = var.lower()
    #var1 = var[0].upper()
    #var2 = var[1:]
    #print"%s - %s " % (var.encode('utf-8'), (var1+var2).encode('utf-8'))
    
    #name = re.findall("\((.*?)\)", item['name'].decode('cp1251').encode('utf-8'))
    #print "%s - %s" % (item['name'], name)
    
    #name = re.sub("\((.*?)\)", "", item['name'].decode('cp1251').encode('utf-8'))
    #print "%s - %s" % (item['name'].decode('cp1251').encode('utf-8'), name.lower())
