#!/usr/local/bin/python
# -*- coding: utf-8 -*-
import os
import sys
from grab import Grab
import DataBase
import datetime
import re

domain_parsing = "http://www.tngtoys.ru/"

def get_abs_path():
    path = os.path.abspath(os.path.dirname(__file__))
    return path

def main():
    grab = Grab()
    items = db.select("select * from _import_product_links")
    if items == None:
        print "Парсинг не требуется"
        sys.exit()

    root = get_abs_path()
    curdate = datetime.date.today()
    dir = str(root) + '/import_logs/' + str(curdate)
    if (os.path.isdir(dir)) == False:
        os.mkdir(dir)

    for item in items:
        grab.go(item['product_from'], log_dir=dir)
        if (grab.response.code == 200):
                
            try:
                description = grab.xpath_text('//*[@class="catalog_list"]//tr//td[2]')
                
                if (description != None):
                    try:
                        description = unicode(description).encode('utf-8')
                        description = re.sub("Арт.\s(.*)\sКод\s\d{1,5}", "", description)
                        age_txt = re.search( "Возраст:(.*)\d{1,2}", description)
                        if age_txt != None:
                            age = re.search("\d", age_txt.group())
                            db.query("update fw_products set age = '%d' where id='%d'" % (int(age.group()), int(item['product_id'])))
                            print "Обновлен возраст для продукта: %d" % int(item['product_id'])

                    except UnicodeEncodeError:
                        print "Ошибка перекодировки"
                
            except IndexError:
                print grab.response.url
                print "Описание не найдено"

            
            
            #db.query("delete from _import_product_links where product_id='%d'" % int(item['product_id']))
    
    print "Сделано."
    
DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")

if __name__ == "__main__":
    main()
