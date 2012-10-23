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
                imagelink = grab.xpath('//*[@class="catalog_list"]//tr//td[1]//a').get("href")
                array = imagelink.replace('javascript:MM_openBrWindow2', '').replace('(','').replace(')','').replace('\'','').split(',')
                image = array[0]
                image_url = domain_parsing + image
                imagearray = image.split('/')
                if len(imagearray) > 0:
                    imagename = imagearray[len(imagearray)-1]
                
                
                imagedir = str(root) + '/uploaded_files/product_images/' + str(item['product_id'])
                if (os.path.isdir(imagedir) == False):
                    os.mkdir(imagedir,0777)

                
                
                if (image_url != None and imagedir != None):
                    fileimage = os.system("/usr/local/bin/wget -c --content-disposition -P %s %s" % (imagedir, image_url))

                if (imagename != None):
                    db.query("insert into product_images (product_id, image) values ('%d', '%s')" % (int(item['product_id']), str(imagename)))
            
            except IndexError:
                print grab.response.url
                print 'Ссылка на картинку не найдена'
                
                
            try:
                description = grab.xpath_text('//*[@class="catalog_list"]//tr//td[2]')
                
                if (description != None):
                    try:
                        
                        description = unicode(description).encode('utf-8')
                        description = re.sub("Арт.\s(.*)\sКод\s\d{1,5}", "", description)
                        
                        age_txt = re.search( "Возраст(.*):(.*)\d{1,2}(.*)лет", description)
                        if age_txt != None:
                            age = re.search("\d{1,2}", age_txt.group())
                            db.query("update fw_products set age = '%d' where id='%d'" % (int(age.group()), int(item['product_id'])))

                        age_txt = ""
                        age_txt = re.search( "детей от(.*)\d{1,2}(.*)лет", description)
                        if age_txt != None:
                            age = re.search("\d{1,2}", age_txt.group())
                            db.query("update fw_products set age = '%d' where id='%d'" % (int(age.group()), int(item['product_id'])))

                        db.query("update fw_products set description = '%s' where id='%d'" % (db.escape(description.decode('utf-8').encode('cp1251')), int(item['product_id'])))
                        
                        
                    except UnicodeEncodeError:
                        print "Ошибка перекодировки текста"
                
            except IndexError:
                print grab.response.url
                print "Описание категории не найденно"

            
            
            db.query("delete from _import_product_links where product_id='%d'" % int(item['product_id']))
            
DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")

if __name__ == "__main__":
    main()
