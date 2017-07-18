
import MySQLdb
 
conn = MySQLdb.connect(host= "localhost", user="root", passwd="am2814698350", db="droplet")

x = conn.cursor() #open MySQL/MariaDB Connection
x.execute("UPDATE schedule SET Cancel_Req = 1")
conn.commit()
print "Row(s) updated :" + str(x.rowcount)

#try:
#	x = conn.cursor() #open MySQL/MariaDB Connection
#	x.execute("UPDATE schedule SET Cancel_Req = 1 WHERE Sch_ID = 1")
#        x.commit()
#	print "Row(s) updated :" + str(x.rowcount)
#except:
#        print "Unable to initiate cancel request:"
#	x.execute('show profiles')
#	for row in x:
#		print(row)
#	x.execute('set profiling = 0')
#
#finally:
x.close()