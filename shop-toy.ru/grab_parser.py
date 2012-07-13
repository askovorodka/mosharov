#!/usr/local/bin/python
# -*- coding: utf-8 -*-
import os
import sys
from grab import Grab
import DataBase
import datetime


def get_abs_path():
    path = os.path.abspath(os.path.dirname(__file__))
    return path

def main():
    grab = Grab()
    items = db.select("select * from _import_product_links")
    if items == None:
        print "Парсинг не требуется"

    root = get_abs_path()
    curdate = datetime.date.today()
    dir = str(root) + '/import_logs/' + str(curdate)
    if (os.path.isdir(dir)) == False:
        os.mkdir(dir)

    grab.go(items[0]['product_from'], log_dir=dir)

DB_HOST, DB_NAME, DB_USER, DB_PASS = "localhost", "shop-toy", "demo", "gthtgenmt"
db = DataBase.Db(DB_NAME,DB_HOST,DB_USER,DB_PASS)
db.query("set CHARACTER SET cp1251")

if __name__ == "__main__":
    main()
