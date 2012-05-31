#!/usr/local/bin/python
# -*- coding: utf-8 -*-
import _mysql

class Db:
    u'Класс для работы с БД'
    __db = ""
    __result = {}
    __result_row = {}
    __result_array = {}
    __query_string = ""
    
    def __init__(self,dbname,dbhost,dbuser,dbpass):
        self.__db = _mysql.connect(dbhost,dbuser,dbpass,dbname)
    
    def select(self, query_string):
        self.__db.query(query_string)
        self.__result = self.__db.store_result()
        if self.__result.num_rows() > 0:
            self.__result_array = self.__result.fetch_row(0,1)
            return self.__result_array
        else:
            return None

    def selectrow(self, query_string):
        self.__db.query(query_string)
        self.__result = self.__db.store_result()
        if self.__result.num_rows() == 1:
            self.__result_row = self.__result.fetch_row(1,1)
            return self.__result_row[0]
        else:
            return None

    def query(self, query_string):
        self.__db.query(query_string)
        
    def last_insert_id(self):
        self.__db.query("select last_insert_id()")
        self.__result = self.__db.store_result()
        self.__result_row = self.__result.fetch_row(1)
        return self.__result_row[0][0]
    
    def escape(self, string):
        return _mysql.escape_string(string)
    
    def close(self):
        self.__db.close()
