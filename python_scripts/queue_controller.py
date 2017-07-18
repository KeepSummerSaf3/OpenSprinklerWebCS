import pyowm
import MySQLdb
from collections import namedtuple
from datetime import datetime, date, time, timedelta
import re

today = date.today()
today_tuple_ = today.timetuple()

time_now = datetime.now()

#MySQL DB Information for Droplet
db = MySQLdb.connect(host="localhost", user="root", passwd="am2814698350", db="droplet")
#Cursor object
cur = db.cursor()

owm = pyowm.OWM('066d502693de8dbdb6065a22d0143a78')  # You MUST provide a valid API key

cur.execute("SELECT * FROM schedule")

#place each row from MySQL in named tuple
queue_row = namedtuple('row_','sch_id dow start_time zone duration delay cancel_conf')

#each named tuple is placed into a list
queue = []

for row in cur.fetchall():
	print("Sch ID:"),
	print(row[1]),
	print(", Time:"),
	print(row[2])
	tmp = row[2].split()
	if tmp[0].upper() == "MON":
		dow_ = 0
	elif tmp[0].upper() == "TUE":
		dow_ = 1
	elif tmp[0].upper() == "WED":
		dow_ = 2
	elif tmp[0].upper() == "THU":
		dow_ = 3
	elif tmp[0].upper() == "FRI":
		dow_ = 4
	elif tmp[0].upper() == "SAT":
		dow_ = 5
	else:
		dow_ = 6
	queue.append(queue_row(row[1], dow_, tmp[1], row[3], row[4], row[5], row[7]))

dt = []
count = 0

for queue_row in queue:
	print "Schedule ID: ",
	print queue_row.sch_id,
	print ", Start Time: ",
	print queue_row.dow,
	print ' ',
	print queue_row.start_time,
	print ", Zone: ",
	print queue_row.zone,
	print ", Duration: ",
	print queue_row.duration,
	print ", Delay: ",
	print queue_row.delay,
	print ", Cancel Confirm: ",
	if queue_row.cancel_conf == 1:
		print "true"
	else:
		print "false"

	day_diff = abs(queue_row.dow - today_tuple_[6])
	#print "Day Diff: ",
	#print day_diff
	#print dt.time()
	#print(today.isoformat() + " 12:00:00+00")
	if day_diff < 2:
		for i in range (3, 8):
			dt = datetime.combine(today, time()) + timedelta(hours=3*i)
			dt_ = dt.strftime('%Y-%m-%d %H:%M:%S') + "+00" 
			#print(dt_)
			if(forc.will_be_rainy_at(dt_) == 1):
				print "Cancel this watering event"
				break
					
				
	#else:
		#today.isoformat() + " 03:00:00+00"
		#forc_w.will_be_rainy_at(
		
	
	print ", Time: ",
	print queue_row_times.time

db.close()