#!/usr/local/bin/python

import MySQLdb

db = MySQLdb.connect("localhost","demo","gthtgenmt","cccp")
cursor = db.cursor()
cursor.execute("select * from fw_products where status='1' limit 5")
results = cursor.fetchall()

for row in results:
	print "%s" % (row[2])

#db.query("select * from fw_products where status='1' limit 5")

#results = db.store_result()

#print results.fetch_row(0)

#for item in results.fetchall():
#	print item[7]


#for row in results:
#    id = row[2]
#    print "id=%s" % (id)

#result = db.store_result()
#print "Total products: %s штук" % (result.num_rows())
#rows = result.fetchall()
