#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import _mysql
import os
import sys
from xml.dom.minidom import Document
import datetime
import codecs
from BeautifulSoup import BeautifulSoup
DOMAIN = 'http://cccp-shina.ru'
IMAGE_PATH = str(DOMAIN) + '/uploaded_files/shop_images/'
SHOP_NAME = "Шины и диски"

def get_config(key = ""):
    if key != "":
        sql = "select * from fw_conf where conf_key = '%s'" % key
    else:
        sql = "select * from fw_conf"
    db.query(sql)
    result = db.store_result()
    if result.num_rows() == 1:
        rs = result.fetch_row(0)
        return rs[0]
    else:
        return result.fetch_row(0)

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
    sql = "select * from fw_catalogue where status='" + status + "' and param_level > 0 order by param_left"
    db.query(sql)
    result = db.store_result()
    categories = result.fetch_row(0)
    categories = list(categories)
    items = []
    for item in categories:
        category = list(item)
        full_url = get_category_full_url(category, 'catalog')
        category.insert(len(category), full_url)
        if int(category[3]) > 1:
            parent = get_parent_category(category, (int(category[3])-1))
            category.insert(len(category), parent[0])

        items.append(category)

    return items


def get_category_full_url(category, module_name = 'catalog'):
    url = str(category[4]) + '/'
    param_level = int(category[3])
    while int(param_level) > 1:
            category = get_parent_category(category, param_level-1)
            url = str(category[4]) + '/' + url
            param_level = int(category[3])
    return '/' + module_name + '/' + url


def get_products():
    status = '1'
    sql = "select fw_products.*, fw_catalogue.image from fw_products left join fw_catalogue on fw_products.parent = fw_catalogue.id where fw_products.status='%s' and (fw_products.tire_sklad > 0 or fw_products.disk_sklad > 0) and fw_catalogue.status = '%s' " % (status, status)
    db.query(sql)
    result = db.store_result()
    products = result.fetch_row(0)

    items = []
    for item in products:
        pr = list(item)
        category = get_category(item[1])
        parent_cat = get_parent_category(category, 2)

        model_name = category[5]
        brand_name = parent_cat[5]

        full_url_product = DOMAIN + get_category_full_url(category, 'catalog') + str(pr[0]) + "/"
        pr.insert(len(pr), full_url_product)
        pr.insert(len(pr), model_name)
        pr.insert(len(pr), brand_name)
        items.append(pr)

    return items


########################main#########################

path = os.path.abspath(os.path.dirname(__file__))
db = _mysql.connect("localhost","cccp","gthtgenmt","cccp")
db.query("set CHARACTER SET cp1251")

conf = get_config('MARKET_RUNNING')

if (int(conf[1]) == 0):
    print "Обновление не требуется"
    db.close()
    sys.exit(0)


categories = get_categories()
curdate = datetime.datetime.now()
products = get_products()
dateformat = "%Y-%m-%d %H:%M:%S"

f = open(path + "/cccp-yandex.xml", "w+")
f.write("<?xml version=\"1.0\" encoding=\"utf-8\"?>")
f.write("<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">")
f.write("<yml_catalog date=\"%s\">" % datetime.datetime.today().strftime(dateformat))


f.write("<shop>")

f.write("<name>%s</name>" % SHOP_NAME)
f.write("<company>%s</company>" % DOMAIN)
f.write("<url>%s</url>" % DOMAIN)
f.write("<currencies>")
f.write("<currency id=\"RUR\" rate=\"1\"/>")
f.write("<currency id=\"USD\" rate=\"CBRF\"/>")
f.write("</currencies>")


f.write("<categories>")
for cat in categories:
    name = cat[5].decode('cp1251').encode('utf-8')
    id = int(cat[0])
    if int(cat[3]) > 0 and int(cat[3]) == 1:
        f.write("<category id=\"%d\"><![CDATA[%s]]></category>" % (id, name))
    if int(cat[3]) > 1:
        pid = int(cat[14])
        f.write("<category id=\"%d\" parentId=\"%d\"><![CDATA[%s]]></category>" % (id, pid, name))
f.write("</categories>")


f.write("<offers>")
for product in products:
    f.write("<offer id=\"%d\" type=\"vendor.model\" available=\"true\">" % int(product[0]))
    f.write("<url>%s</url>" % product[40])
    f.write("<price>%s</price>" % product[7])
    f.write("<currencyId>RUR</currencyId>")
    f.write("<categoryId>%d</categoryId>" % int(product[1]))
    if product[39] != '':
        f.write("<picture>%s</picture>" % (IMAGE_PATH + product[39]))
    f.write("<store>true</store>")
    f.write("<pickup>true</pickup>")
    f.write("<delivery>true</delivery>")
    #f.write("<local_delivery_cost>500</local_delivery_cost>")

    if (product[17] != "0.00" and product[17] > 0):
        f.write("<typePrefix>Диски</typePrefix>")
    else:
        f.write("<typePrefix>Шины</typePrefix>")

    #производитель
    f.write("<vendor><![CDATA[%s]]></vendor>" % product[42].decode('cp1251').encode('utf-8'))
    #модель
    if product[17] != "0.00" and product[17] > 0:
        f.write("<model><![CDATA[%s %sx%s Dia%s %s]]></model>" % (product[41].decode('cp1251').encode('utf-8'), product[17], product[18], product[23], product[24].decode('cp1251').encode('utf-8')))
    else:
        f.write("<model><![CDATA[%s %s/%s R%s]]></model>" % (product[41].decode('cp1251').encode('utf-8'), product[27], product[28], product[29]))

    if (product[26] != None):
        disk_sklad = int(product[26])
    if (product[35] != None):
        tire_sklad = int(product[35])
    if disk_sklad > 3 or tire_sklad > 3:
        f.write("<sales_notes>Заказ от 4. Менее по согласованию.</sales_notes>")
    elif disk_sklad > 0:
        f.write("<sales_notes>Заказ от %d шт.</sales_notes>" % disk_sklad)
    elif tire_sklad > 0:
        f.write("<sales_notes>Заказ от %d шт.</sales_notes>" % tire_sklad)


    if product[17] != "0.00" and product[17] > 0:
        f.write("<param name=\"Ширина\"><![CDATA[%s]]></param>" % product[17])
        f.write("<param name=\"Диаметр\"><![CDATA[%s]]></param>" % product[18])
        f.write("<param name=\"Dia\"><![CDATA[%s]]></param>" % product[23])
        f.write("<param name=\"Крепеж\"><![CDATA[%s]]></param>" % product[19])
        f.write("<param name=\"PCD\"><![CDATA[%s]]></param>" % product[20])
        f.write("<param name=\"PCD (двойной)\"><![CDATA[%s]]></param>" % product[21])
        f.write("<param name=\"ET\"><![CDATA[%s]]></param>" % product[22])
        f.write("<param name=\"Цвет\"><![CDATA[%s]]></param>" % product[24].decode('cp1251').encode('utf-8'))
    else:
        f.write("<param name=\"Ширина\"><![CDATA[%s]]></param>" % product[27])
        f.write("<param name=\"Профиль\"><![CDATA[%s]]></param>" % product[28])
        f.write("<param name=\"Диаметр\"><![CDATA[%s]]></param>" % product[29])
        if product[30] != "":
            f.write("<param name=\"Индекс нагрузки\"><![CDATA[%s]]></param>" % product[30].decode('cp1251').encode('utf-8'))
        if product[31] != "":
            f.write("<param name=\"Индекс скорости\"><![CDATA[%s]]></param>" % product[31].decode('cp1251').encode('utf-8'))

    f.write("</offer>")
f.write("</offers>")

f.write("</shop>")

f.write("</yml_catalog>")

f.close()

#обновляем индикатор ЯД
db.query("update fw_conf set conf_value='0' where conf_key='MARKET_RUNNING'")
db.close()
