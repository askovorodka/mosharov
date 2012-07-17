#!/usr/local/bin/python
# -*- coding: utf-8 -*-


import _mysql
import os
import sys
from xml.dom.minidom import Document
import datetime
import time

DOMAIN = 'http://itire.ru'
IMAGE_PATH = str(DOMAIN) + '/uploaded_files/shop_images/'
DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "itire", "itire", "gthtgenmt"
db = _mysql.connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)
db.query("set CHARACTER SET cp1251")
path = os.path.abspath(os.path.dirname(__file__))
TIRES_ID = 2
DISK_ID = 3
last_time = time.time()

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


def get_categories():
    status = '1'
    sql = "select id, param_level, param_left, param_right, name, url, text,image, meta_description, meta_keywords,title from fw_catalogue where status='" + status + "' and param_level > 1 order by param_left"
    db.query(sql)
    result = db.store_result()
    categories = result.fetch_row(0, 1)
    return categories


def get_parent_category(category, param_level):
    param_left = category['param_left']
    param_right = category['param_right']
    sql = "select a.id as pid, a.param_level as p_param_level, a.name as pname, a.url as purl, b.id as type from fw_catalogue as a left join fw_catalogue as b on b.param_left <= a.param_left and b.param_right >= a.param_right and b.param_level=1 where a.param_left < '" + param_left + "' and a.param_right > '" + param_right + "' and a.param_level = '" + str(param_level) + "'"
    #sql = "select * from fw_catalogue where param_left < '" + param_left + "' and param_right > '" + param_right + "' and param_level = '" + str(param_level) + "'"
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

    conf = get_config('EXPORT_RUNNING')
    
    if (int(conf[1]) == 0):
        print "Обновление не требуется"
        db.close()
        sys.exit(0)
    
    
    categories = get_categories()
    curdate = datetime.datetime.now()
    products = get_products()
    
    #goodrims.ru
    goodrims_tire_koef = get_config('GOODRIMS_TIRE_KOEF')
    goodrims_tire_koef = float(goodrims_tire_koef[1])
    
    goodrims_tire_round_koef = get_config('GOODRIMS_TIRE_ROUND_KOEF')
    goodrims_tire_round_koef = int(goodrims_tire_round_koef[1])
    
    goodrims_disk_koef = get_config('GOODRIMS_DISK_KOEF')
    goodrims_disk_koef = float(goodrims_disk_koef[1])
    
    goodrims_disk_round_koef = get_config('GOODRIMS_DISK_ROUND_KOEF')
    goodrims_disk_round_koef = int(goodrims_disk_round_koef[1])

    goodrims_enable = get_config('GOODRIMS_ENABLE')
    goodrims_enable = int(goodrims_enable[1])
	


    #selltire.ru
    selltire_tire_koef = get_config('SELLTIRE_TIRE_KOEF')
    selltire_tire_koef = float(selltire_tire_koef[1])
    
    selltire_tire_round_koef = get_config('SELLTIRE_TIRE_ROUND_KOEF')
    selltire_tire_round_koef = int(selltire_tire_round_koef[1])
    
    selltire_disk_koef = get_config('SELLTIRE_DISK_KOEF')
    selltire_disk_koef = float(selltire_disk_koef[1])
    
    selltire_disk_round_koef = get_config('SELLTIRE_DISK_ROUND_KOEF')
    selltire_disk_round_koef = int(selltire_disk_round_koef[1])

    selltire_enable = get_config('SELLTIRE_ENABLE')
    selltire_enable = int(selltire_enable[1])
    
    
    #cccp-shina.ru
    cccp_tire_koef = get_config('CCCP_TIRE_KOEF')
    cccp_tire_koef = float(cccp_tire_koef[1])
    
    cccp_tire_round_koef = get_config('CCCP_TIRE_ROUND_KOEF')
    cccp_tire_round_koef = int(cccp_tire_round_koef[1])
    
    cccp_disk_koef = get_config('CCCP_DISK_KOEF')
    cccp_disk_koef = float(cccp_disk_koef[1])
    
    cccp_disk_round_koef = get_config('CCCP_DISK_ROUND_KOEF')
    cccp_disk_round_koef = int(cccp_disk_round_koef[1])
    
    cccp_enable = get_config('CCCP_ENABLE')
    cccp_enable = int(cccp_enable[1])
	
	
    f = open(path + "/export.xml", "w+")
    f.write("<?xml version=\"1.0\" encoding=\"utf-8\"?>")
    f.write("<catalog date=\"%s\">" % curdate)
	
    f.write("<categories>")
    for cat in categories:
        param = 1
        parent = get_parent_category(cat, int(cat['param_level']) - 1)
        f.write("<category id=\"%d\" pid=\"%d\" param_level=\"%d\" type=\"%d\">" % (int(cat['id']), int(parent['pid']), int(cat['param_level']), int(parent['type'])))
        f.write("<name><![CDATA[%s]]></name>" % cat['name'].decode('cp1251').encode('utf-8'))
        f.write("<url><![CDATA[%s]]></url>" % cat['url'].decode('cp1251').encode('utf-8'))
        f.write("<title><![CDATA[%s]]></title>" % cat['title'].decode('cp1251').encode('utf-8'))
        f.write("<text><![CDATA[%s]]></text>" % cat['text'].decode('cp1251').encode('utf-8'))
        f.write("<image><![CDATA[%s]]></image>" % cat['image'].decode('cp1251').encode('utf-8'))
        f.write("<meta_description><![CDATA[%s]]></meta_description>" % cat['meta_description'].decode('cp1251').encode('utf-8'))
        f.write("<meta_keywords><![CDATA[%s]]></meta_keywords>" % cat['meta_keywords'].decode('cp1251').encode('utf-8'))
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

        if (product['tire_width'] != None and int(product['tire_width']) > 0 and product['tire_width'] != "0.00" and product['tire_width'] != "0"):
            f.write("<tire_width><![CDATA[%s]]></tire_width>" % product['tire_width'])
            f.write("<tire_height><![CDATA[%s]]></tire_height>" % product['tire_height'])
            f.write("<tire_diameter><![CDATA[%s]]></tire_diameter>" % product['tire_diameter'])
            f.write("<tire_width><![CDATA[%s]]></tire_width>" % product['tire_width'])
            f.write("<tire_in><![CDATA[%s]]></tire_in>" % product['tire_in'].decode('cp1251').encode('utf-8'))
            f.write("<tire_is><![CDATA[%s]]></tire_is>" % product['tire_is'].decode('cp1251').encode('utf-8'))
            f.write("<tire_usil><![CDATA[%s]]></tire_usil>" % product['tire_usil'].decode('cp1251').encode('utf-8'))
            f.write("<tire_spike>%d</tire_spike>" % int(product['tire_spike']))
            if product['tire_season'] != None and product['tire_season'] != "":
                f.write("<tire_season>%d</tire_season>" % int(product['tire_season']))
            else:
                f.write("<tire_season>0</tire_season>")
            f.write("<tire_sklad>%d</tire_sklad>" % int(product['tire_sklad']))
            f.write("<tire_bodytype>%d</tire_bodytype>" % int(product['tire_bodytype']))

        f.write("</product>")
    f.write("</products>")
    
    
    f.write("</catalog>")
    
    f = open(path + "/export_run.xml", "w+")
    f.write("<?xml version=\"1.0\" encoding=\"utf-8\"?>")
    
    f.write("<items>")
    f.write("<last_update date=\"%f\"></last_update>" % last_time)
    f.write("<goodrims tire_koef=\"%f\" disk_koef=\"%f\" tire_round_koef=\"%d\" disk_round_koef=\"%d\" enable=\"%d\"></goodrims>" % (goodrims_tire_koef, goodrims_disk_koef, goodrims_tire_round_koef, goodrims_disk_round_koef, goodrims_enable))
    f.write("<selltire tire_koef=\"%f\" disk_koef=\"%f\" tire_round_koef=\"%d\" disk_round_koef=\"%d\" enable=\"%d\"></selltire>" % (selltire_tire_koef, selltire_disk_koef, selltire_tire_round_koef, selltire_disk_round_koef, selltire_enable))
    f.write("<cccp tire_koef=\"%f\" disk_koef=\"%f\" tire_round_koef=\"%d\" disk_round_koef=\"%d\" enable=\"%d\"></cccp>" % (cccp_tire_koef, cccp_disk_koef, cccp_tire_round_koef, cccp_disk_round_koef, cccp_enable))
    f.write("</items>")
    
    db.query("update fw_conf set conf_value='0' where conf_key='EXPORT_RUNNING'")
    db.query("update fw_conf set conf_value='%f' where conf_key='EXPORT_LAST_TIME'" % last_time)
    print "Выгрузка обновлена"
    
    f.close()
    db.close()
    pass
    
if __name__ == '__main__':
    main()
