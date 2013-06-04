#!/usr/local/bin/python
# -*- coding: utf-8 -*-

import datetime
import _mysql
from BeautifulSoup import BeautifulStoneSoup
import urllib2
import sys
import time
import os


DB_HOST = 'localhost'
DB_NAME='prod'
DB_USER='cccp'
DB_PASS='gthtgenmt'
TIRES_ID = 2
DISK_ID = 3
#DISK_PRICE_KOEF = 10.0
#TIRE_PRICE_KOEF = 5.0

db = _mysql.connect(DB_HOST,DB_USER,DB_PASS,DB_NAME)
db.query("set CHARACTER SET cp1251")


def get_config(key = ""):
    if key != "":
        sql = "select * from fw_conf where conf_key = '%s'" % key
    else:
        sql = "select * from fw_conf"
    db.query(sql)
    result = db.store_result()
    if result.num_rows() == 1:
        rs = result.fetch_row(0,1)
        return rs[0]
    else:
        return result.fetch_row(0,1)


update_xml = urllib2.urlopen("http://itire.ru/export_run.xml")
update_soup = BeautifulStoneSoup(update_xml)
last_run = update_soup.items.last_update
goodrims_vars = update_soup.items.goodrims


last = get_config('IMPORT_LAST_TIME')
if float(last['conf_value']) == float(last_run['date']):
    print "Импорт не актуален"
    db.close()
    sys.exit()
else:
    db.query("update fw_conf set conf_value='%s' where conf_key='IMPORT_LAST_TIME'" % last_run['date'])


DISK_PRICE_KOEF = float(goodrims_vars['disk_koef'])
TIRE_PRICE_KOEF = float(goodrims_vars['tire_koef'])

DISK_ROUND_KOEF = int(goodrims_vars['disk_round_koef'])
TIRE_ROUND_KOEF = int(goodrims_vars['tire_round_koef'])

GOODRIMS_ENABLE = int(goodrims_vars['enable'])

if GOODRIMS_ENABLE != 1:
    print "Импорт выключен для этого сайта"
    db.close()
    sys.exit()

page = urllib2.urlopen("http://itire.ru/export.xml")
soup = BeautifulStoneSoup(page)


def get_category(id):
    sql = "select * from fw_catalogue where id = '%d'" % int(id)
    db.query(sql)
    result = db.store_result()
    category = result.fetch_row(1,1)
    return category[0]

def clear():
    db.query("truncate test")
    db.query("insert into test (param_left, param_right, param_level) values(1,2,0)")
    return last_insert_id()

def last_insert_id():
    db.query("select last_insert_id()")
    result = db.store_result()
    row = result.fetch_row(1)
    return row[0][0]


def insert(category):
    param_left = category['param_left']
    param_right = category['param_right']
    param_level = category['param_level']
    new_param_right = int(param_right) + 1
    new_param_level = int(param_level) + 1
    sql = ''' UPDATE fw_catalogue SET 
        param_left = IF(param_left> %d, param_left+2,param_left),
        param_right = IF(param_right >= %d,param_right+2,param_right) 
        WHERE param_right >= %d''' % (int(param_right), int(param_right), int(param_right))
        
    db.query(sql)
    sql = "insert into fw_catalogue (param_left, param_right, param_level) values (%d, %d, %d)" % (int(param_right), new_param_right, new_param_level)
    db.query(sql)
    return int(last_insert_id())


def get_parent_category(category, param_level):
    param_left = category['param_left']
    param_right = category['param_right']
    sql = "select * from fw_catalogue where param_left < '" + param_left + "' and param_right > '" + param_right + "' and param_level = '" + str(param_level) + "'"
    db.query(sql)
    result = db.store_result()
    if (result.num_rows() > 0):
        row = result.fetch_row(0,1)
        return row[0]
    else:
        return

def search_category(name, param_level, type, parent = None):
    if parent != None:
        sql = ''' select a.*, c.id from fw_catalogue as a 
        left join fw_catalogue as b on b.param_left <= a.param_left 
        and b.param_right >= a.param_right and b.param_level = 1
        left join fw_catalogue as c on c.param_left < a.param_left and c.param_right > a.param_right and c.param_level = %d
        where a.name = '%s' and a.param_level = '%d' 
        and b.id = '%d' and c.id = %d ''' % ((int(param_level)-1), str(name), int(param_level), int(type), int(parent))
    else:
        sql = ''' select a.* from fw_catalogue as a 
        left join fw_catalogue as b on b.param_left <= a.param_left 
        and b.param_right >= a.param_right and b.param_level = 1
        where a.name = '%s' and a.param_level = '%d' and b.id = '%d' ''' % (str(name), int(param_level), int(type))
    db.query(sql)
    result = db.store_result()
    if (result.num_rows() > 0):
        row = result.fetch_row(0,1)
        return row[0]
    else:
        return

def search_tire(parent, name, tire_width, tire_height, tire_diameter, tire_in, tire_is):
    sql = ''' select * from fw_products 
    where parent='%d' and name='%s' and tire_width='%f' and tire_height='%f'
    and tire_diameter = '%f' and tire_in='%s' and tire_is = '%s' ''' % (int(parent), str(name), float(tire_width), float(tire_height), float(tire_diameter), str(tire_in), str(tire_is))
    db.query(sql)
    result = db.store_result()
    if result.num_rows() > 0:
        row = result.fetch_row(0,1)
        return row[0]
    else:
        return

def search_disk(parent, name, disk_width, disk_diameter):
    sql = ''' select * from fw_products 
    where parent='%d' and name='%s' and disk_width='%f' and disk_diameter='%f'
    ''' % (int(parent), str(name), float(disk_width), float(disk_diameter))
    db.query(sql)
    result = db.store_result()
    if result.num_rows() > 0:
        row = result.fetch_row(0,1)
        return row[0]
    else:
        return
        

steptime = time.time()

#id = clear()
categories = soup.catalog.categories.findAll(param_level="2")
products = soup.catalog.products

db.query("update fw_catalogue set status='0' where param_level > 1")
db.query("update fw_products set status='0'")
db.query("truncate images_cron")

for cat in categories:
    
    item = {}
    cat_id = int(cat['id'])
    parent_id = cat['pid']
    type = cat['type']
    item['param_level'] = cat['param_level']
    item['name'] = cat.contents[0].contents[0].encode('cp1251')
    item['url'] = cat.contents[1].contents[0].encode('cp1251')
    item['title'] = cat.contents[2].contents[0].encode('cp1251')
    item['text'] = cat.contents[3].contents[0].encode('cp1251')
    item['image'] = cat.contents[4].contents[0].encode('cp1251')
    item['meta_keywords'] = cat.contents[5].contents[0].encode('cp1251')
    item['meta_description'] = cat.contents[6].contents[0].encode('cp1251')
    
    search = search_category(item['name'], item['param_level'], type)
    if search == None:
        parent = get_category(int(type))
        new_id = insert(parent)
    else:
        new_id = search['id']
    
    db.query("update fw_catalogue set status='1', name='%s', url='%s', title='%s', text='%s', meta_keywords='%s', meta_description='%s' where id='%d'" % (item['name'], item['url'], item['title'], item['text'], item['meta_keywords'], item['meta_description'], int(new_id)))
    db.query("replace into images_cron (cat_id, image) values('%d', '%s')" % (int(new_id), item['image']))
    subcats = soup.catalog.categories.findAll(param_level = "3")
    for subcat in subcats:
        if int(subcat['pid']) == int(cat_id):
            subitem = {}
            subitem['param_level'] = subcat['param_level']
            old_id = subcat['id']
            subtype = subcat['type']
            subitem['name'] = subcat.contents[0].contents[0].encode('cp1251')
            subitem['url'] = subcat.contents[1].contents[0].encode('cp1251')
            subitem['title'] = subcat.contents[2].contents[0].encode('cp1251')
            subitem['text'] = subcat.contents[3].contents[0].encode('cp1251')
            subitem['image'] = subcat.contents[4].contents[0].encode('cp1251')
            subitem['meta_keywords'] = subcat.contents[5].contents[0].encode('cp1251')
            subitem['meta_description'] = subcat.contents[6].contents[0].encode('cp1251')
            
            subsearch = search_category(subitem['name'], subitem['param_level'], subtype, new_id)
            if subsearch == None:
                parent_cat = get_category(new_id)
                sub_new_id = insert(parent_cat)
            else:
                sub_new_id = subsearch['id']
            
            db.query("update fw_catalogue set status='1', name='%s', url='%s', title='%s', text='%s', meta_keywords='%s', meta_description='%s' where id='%d'" % (subitem['name'], subitem['url'], subitem['title'], subitem['text'], subitem['meta_keywords'], subitem['meta_description'], int(sub_new_id)))
            db.query("replace into images_cron (cat_id, image) values('%d', '%s')" % (int(sub_new_id), subitem['image']))
            print "Обновлена категория: %s" % subitem['name']
            
            for product in products:
                if int(product['parent']) == int(old_id):
                	#Работаем с шинами
                    if int(subtype) == 2:
                        article = int(product['article'])
                        name = product.contents[0].contents[0].encode('cp1251')
                        price = float(product.contents[1].contents[0])
                        hash = product.contents[2].contents[0]
                        dictionary = str(product.contents[3].contents[0].encode('cp1251'))
                        tire_width = float(product.contents[4].contents[0])
                        tire_height = float(product.contents[5].contents[0])
                        tire_diameter = float(product.contents[6].contents[0])
                        tire_in = product.contents[8].contents[0].encode('cp1251')
                        tire_is = product.contents[9].contents[0].encode('cp1251')
                        tire_usil = product.contents[10].contents[0].encode('cp1251')
                        tire_spike = int(product.contents[11].contents[0])
                        tire_season = int(product.contents[12].contents[0])
                        tire_sklad = int(product.contents[13].contents[0])
                        tire_bodytype = int(product.contents[14].contents[0])
                        item = search_tire(sub_new_id, name, tire_width, tire_height, tire_diameter, tire_in, tire_is)
                        #задаем коэфициент цены
                        price2 = float(price + (price * float(TIRE_PRICE_KOEF/100)))
                        price2 = round(price2)
                        while (price2 % TIRE_ROUND_KOEF != 0.0):
                        	price2 = price2+1
                        	print "Прибавлена цена к шине %f" % price2
                        
                        
                        if item == None:
                            db.query(''' 
                                insert into fw_products 
                                    (article,parent, name, price, tire_width, 
                                    tire_height, tire_diameter, tire_in, tire_is, 
                                    tire_usil, tire_spike, tire_season, tire_sklad, tire_bodytype, dictionary, status)
                                values ('%d','%d', '%s', '%f', '%f', '%f', '%f', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%s', '1')    
                                ''' % (article, int(sub_new_id), name, price2, tire_width,tire_height,tire_diameter,tire_in, tire_is, tire_usil,tire_spike,tire_season,tire_sklad,tire_bodytype,dictionary ))
                            print "Добавлен продукт шина: %s" % name
                        else:
                            
                            db.query(''' update fw_products set article = '%d',
                            name = '%s', price = '%f', tire_width = '%f', 
                            tire_height = '%f', tire_diameter = '%f', tire_in = '%s', tire_is = '%s', 
                            tire_usil = '%s', tire_spike = '%d', tire_season = '%d', tire_sklad = '%d', 
                            tire_bodytype = '%d', dictionary = '%s', status='1' where id = '%d'
                            ''' % (article, name, price2, tire_width,tire_height,tire_diameter,tire_in, tire_is, tire_usil,tire_spike,tire_season,tire_sklad,tire_bodytype,dictionary, int(item['id']) ))
                            print "Обновлен продукт шина: %s" % name
                    #Работаем с дисками
                    elif int(subtype) == 3:
                        article = int(product['article'])
                        name = product.contents[0].contents[0].encode('cp1251')
                        price = float(product.contents[1].contents[0])
                        hash = product.contents[2].contents[0]
                        dictionary = str(product.contents[3].contents[0].encode('cp1251'))
                        disk_width = float(product.contents[4].contents[0])
                        disk_diameter = float(product.contents[5].contents[0])
                        disk_krep = int(product.contents[6].contents[0])
                        disk_pcd = float(product.contents[7].contents[0])
                        disk_pcd2 = float(product.contents[8].contents[0])
                        disk_et = float(product.contents[9].contents[0])
                        disk_dia = float(product.contents[10].contents[0])
                        disk_type = int(product.contents[12].contents[0])
                        disk_sklad = int(product.contents[13].contents[0])
                        disk_color = product.contents[14].contents[0].encode('cp1251')
                        item = search_disk(sub_new_id, name, disk_width, disk_diameter)
                        
                        #задаем коэфициент цены
                        price2 = float(price + (price * float(DISK_PRICE_KOEF/100)))
                        price2 = round(price2)
                        while (price2 % DISK_ROUND_KOEF != 0.0):
                        	price2 = price2+1
                        
                        if item == None:
                            db.query('''insert into fw_products
                            (article, parent,name,price,disk_width,disk_diameter,
                            disk_krep,disk_pcd,disk_pcd2,disk_et,disk_dia,
                            disk_color,disk_type,disk_sklad,dictionary, status)
                            values('%d', '%d','%s','%f','%f', '%f','%d','%f','%f','%f','%f','%s','%d','%d','%s', '1')
                            ''' % (article, int(sub_new_id), name, price2, disk_width, disk_diameter,disk_krep, disk_pcd, disk_pcd2, disk_et, disk_dia, str(disk_color),disk_type, disk_sklad, dictionary))
                            print "Добавлен продукт диск: %s" % name
                        else:
                            db.query('''update fw_products set article = '%d', name='%s', price='%f', disk_width='%f',
                            disk_diameter='%f', status='1', disk_sklad = '%d' 
                            where id='%d' ''' % (article, name, price2, disk_width, disk_diameter, disk_sklad, int(item['id'])))
                            print "Обновлен продукт диск: %s" % name
          

db.query("update fw_conf set conf_value='1' where conf_key='MARKET_RUNNING'")
db.query("update fw_conf set conf_value='%s' where conf_key='IMPORT_LAST_TIME'" % last_run['date'])              
db.close()

steptime = time.time() - steptime
print "Время выполнения: %d сек." % int(steptime)

cmd = "/usr/local/bin/php /home/schmitz/data/www/goodrims.ru/images_downloader.php"
#os.system(cmd)
