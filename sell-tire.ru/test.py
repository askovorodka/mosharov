#!/usr/local/bin/python
# -*- coding: utf-8 -*-

#import MySQLdb
import _mysql
import os
from xml.dom.minidom import Document
import datetime
import codecs
from BeautifulSoup import BeautifulSoup
DOMAIN = 'http://wheels.mosharov.com'
IMAGE_PATH = str(DOMAIN) + '/uploaded_files/shop_images/'



def get_category(id):
    sql = "select * from fw_catalogue where id = '%d'" % int(id)
    db.query(sql)
    result = db.store_result()
    category = result.fetch_row(1)
    return category[0]

def get_parent_category(category, param_level):
    param_left = category[1]
    param_right = category[2]
    sql = "select * from fw_catalogue where param_left < '" + param_left + "' and param_right > '" + param_right + "' and param_level = '" + str(param_level) + "'"
    db.query(sql)
    result = db.store_result()
    if (result.num_rows() > 0):
        row = result.fetch_row()
        return row[0]
    else:
        return


def get_categories():
    status = '1'
    sql = "select * from fw_catalogue where status='" + status + "' order by param_left"
    db.query(sql)
    result = db.store_result()
    categories = result.fetch_row(0)
    categories = list(categories)
    items = []
    for item in categories:
        category = list(item)
        full_url = get_category_full_url(category, 'shop')
        category.insert(len(category), full_url)
        if int(category[3]) > 1:
            parent = get_parent_category(category, (int(category[3])-1))
            category.insert(len(category), parent[0])
            
        items.append(category)
        
    return items


def get_category_full_url(category, module_name = 'shop'):
    url = str(category[4]) + '/'
    param_level = int(category[3])
    while int(param_level) > 1:
            category = get_parent_category(category, param_level-1)
            url = str(category[4]) + '/' + url
            param_level = int(category[3])
    return '/' + module_name + '/' + url


def get_products():
    status = '1'
    sql = "select fw_products.*, fw_catalogue.image from fw_products left join fw_catalogue on fw_products.parent = fw_catalogue.id where fw_products.status='%s' and fw_catalogue.status = '%s' " % (status, status)
    db.query(sql)
    result = db.store_result()
    products = result.fetch_row(0)
    
    items = []
    for item in products:
        pr = list(item)
        category = get_category(item[1])
        full_url_product = DOMAIN + get_category_full_url(category, 'shop') + str(pr[0]) + "/"
        pr.insert(len(pr), full_url_product)
        items.append(pr)
    
    return items

########################main#########################

db = _mysql.connect("localhost","demo","gthtgenmt","cccp")

db.query("set CHARACTER SET cp1251")

categories = get_categories()
curdate = datetime.datetime.now()
products = get_products()


#print os.path.abspath(os.path.join(os.path.dirname(__file__),".."))
path = os.path.abspath(os.path.dirname(__file__))
doc = Document()

shop = doc.createElement("shop")
shop = doc.createElement("shop")
cats = doc.createElement("categories")
cats.setAttribute("date", str(curdate))

for cat in categories:
    if int(cat[3]) > 0:
        category = doc.createElement("category")
        category.setAttribute("id", cat[0].decode('cp1251'))
        
        if int(cat[3]) > 1:
            category.setAttribute("parentId", cat[14].decode('cp1251'))
        
        text = doc.createTextNode( "<![CDATA[%s]]>" % cat[5].decode('cp1251'))
        
        category.appendChild(text)
        cats.appendChild(category)

prod = doc.createElement("offers")
for product in products:
    offer = doc.createElement("offer")
    offer.setAttribute("id", product[0].decode('cp1251'))
    offer.setAttribute("available", "true")
    url = doc.createElement("url")
    url_text = doc.createTextNode(product[40].decode('cp1251'))
    picture = doc.createElement("picture")
    picture_src = doc.createTextNode( IMAGE_PATH + product[39].decode('cp1251') )
    name = doc.createElement("name")
    name_str = doc.createTextNode( "<![CDATA[%s]]>" % product[2].decode('cp1251') )
    
    url.appendChild(url_text)
    picture.appendChild(picture_src)
    name.appendChild(name_str)
    offer.appendChild(url)
    offer.appendChild(picture)
    offer.appendChild(name)
    prod.appendChild(offer)
    
shop.appendChild(cats)
shop.appendChild(prod)
doc.appendChild(shop)


#file = codecs.open(path + "/yandexmarket.xml", "w+")
#file.writelines(doc.toprettyxml(encoding = "utf-8"))
#file.writelines(doc.toprettyxml().encode('utf-8'))
#file.close()

f = open(path + "/yandexmarket.xml", "w+")
f.write(doc.toprettyxml(encoding = "utf-8").encode('utf-8'))
f.close()

#print datetime.datetime.now()
#print doc.toprettyxml(indent = " ")

#xml = xmlp.parse(path + "/yandexmarket.xml")
#for item in results.fetch_row(0):
#    param_level = int(item[3])
#    full_url = get_category_full_url(item, 'shop')
