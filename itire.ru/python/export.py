#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import _mysql
import os
import sys
from xml.dom.minidom import Document
import datetime

DOMAIN = 'http://itire.ru'
IMAGE_PATH = str(DOMAIN) + '/uploaded_files/shop_images/'
DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "itire", "itire", "gthtgenmt"
db = _mysql.connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)
db.query("set CHARACTER SET cp1251")
path = os.path.abspath(os.path.dirname(__file__))


def get_categories():
    status = '1'
    sql = "select id, param_level, param_left, param_right, name, url, text from fw_catalogue where status='" + status + "' and param_level > 0 order by param_left"
    db.query(sql)
    result = db.store_result()
    categories = result.fetch_row(0, 1)
    return categories


def get_parent_category(category, param_level):
    param_left = category['param_left']
    param_right = category['param_right']
    sql = "select id as pid, param_level as p_param_level, name as pname, url as purl from fw_catalogue where param_left < '" + param_left + "' and param_right > '" + param_right + "' and param_level = '" + str(param_level) + "'"
    db.query(sql)
    result = db.store_result()
    if (result.num_rows() > 0):
        row = result.fetch_row(0,1)
        return row[0]
    else:
        return


def get_products():
    sql = ''' select * from fw_products where status='1' '''
    db.query(sql)
    result = db.store_result()
    return result.fetch_row(0, 1)


def main():
    
    categories = get_categories()
    curdate = datetime.datetime.now()
    products = get_products()
    
    f = open(path + "/export.xml", "w+")
    f.write("<?xml version=\"1.0\" encoding=\"utf-8\"?>")
    f.write("<catalog date=\"%s\">" % curdate)


    f.write("<categories>")
    for cat in categories:
        parent = get_parent_category(cat, int(cat['param_level']) - 1)
        f.write("<category id=\"%d\" pid=\"%d\">" % (int(cat['id']), int(parent['pid'])))
        f.write("<param_level><![CDATA[%d]]></param_level>" % int(cat['param_level']))
        f.write("<name><![CDATA[%s]]></name>" % cat['name'].decode('cp1251').encode('utf-8'))
        f.write("</category>")
    f.write("</categories>")


    f.write("<products>")
    for product in products:
        f.write("<product id=\"%d\" article=\"%d\" parent=\"%d\">" % (int(product['id']), int(product['article']), int(product['parent'])))
        f.write("<name><![CDATA[%s]]></name>" % product['name'].decode('cp1251').encode('utf-8'))
        f.write("<price><![CDATA[%s]]></price>" % product['price'])
        f.write("<hash><![CDATA[%s]]></hash>" % product['hash'].decode('cp1251').encode('utf-8'))        
        f.write("<dictionary><![CDATA[%s]]></dictionary>" % product['dictionary'].decode('cp1251').encode('utf-8'))
        if (product['disk_width'] > 0 and product['disk_width'] != "0.00"):
            f.write("<disk_width><![CDATA[%s]]></disk_width>" % product['disk_width'])
            f.write("<disk_diameter><![CDATA[%s]]></disk_diameter>" % product['disk_diameter'])
            f.write("<disk_krep><![CDATA[%s]]></disk_krep>" % product['disk_krep'])
            f.write("<disk_pcd><![CDATA[%s]]></disk_pcd>" % product['disk_pcd'])
            f.write("<disk_pcd2><![CDATA[%s]]></disk_pcd2>" % product['disk_pcd2'])
            f.write("<disk_et><![CDATA[%s]]></disk_et>" % product['disk_et'])
            f.write("<disk_dia><![CDATA[%s]]></disk_dia>" % product['disk_dia'])
            f.write("<disk_krep><![CDATA[%s]]></disk_krep>" % product['disk_krep'])
            f.write("<disk_type><![CDATA[%s]]></disk_type>" % product['disk_type'])
            f.write("<disk_sklad><![CDATA[%d]]></disk_sklad>" % int(product['disk_sklad']))
            if (product['disk_color'] != None):
                f.write("<disk_color><![CDATA[%s]]></disk_color>" % product['disk_color'].decode('cp1251').encode('utf-8'))
        
        if (product['tire_width'] > 0 and product['tire_width'] != "0.00"):
            f.write("<tire_width><![CDATA[%s]]></tire_width>" % product['tire_width'])
            f.write("<tire_height><![CDATA[%s]]></tire_height>" % product['tire_height'])
            f.write("<tire_diameter><![CDATA[%s]]></tire_diameter>" % product['tire_diameter'])
            f.write("<tire_width><![CDATA[%s]]></tire_width>" % product['tire_width'])
            f.write("<tire_in><![CDATA[%s]]></tire_in>" % product['tire_in'].decode('cp1251').encode('utf-8'))
            f.write("<tire_is><![CDATA[%s]]></tire_is>" % product['tire_is'].decode('cp1251').encode('utf-8'))
            f.write("<tire_usil><![CDATA[%s]]></tire_usil>" % product['tire_usil'].decode('cp1251').encode('utf-8'))
            f.write("<tire_spike><![CDATA[%s]]></tire_spike>" % product['tire_spike'])
            f.write("<tire_season><![CDATA[%s]]></tire_season>" % product['tire_season'])
            f.write("<tire_sklad><![CDATA[%s]]></tire_sklad>" % product['tire_sklad'])
            f.write("<tire_bodytype><![CDATA[%s]]></tire_bodytype>" % product['tire_bodytype'])
        
        f.write("</product>")
    f.write("</products>")
    
    
    f.write("</catalog>")
    f.close()
    db.close()
    pass

if __name__ == '__main__':
    main()
