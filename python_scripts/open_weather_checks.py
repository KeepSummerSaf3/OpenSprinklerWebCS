import pyowm
import MySQLdb
from collections import namedtuple
from datetime import datetime, date, time, timedelta
import re

#Pyowm Object
owm = pyowm.OWM('066d502693de8dbdb6065a22d0143a78')  # You MUST provide a valid API key

obs = owm.weather_at_place('Houston,us')
obs_w = obs.get_weather()
forc = owm.three_hours_forecast('Houston,us')
forc_w = forc.get_forecast()

#MySQL DB Information for Droplet
db = MySQLdb.connect(host="localhost", user="root", passwd="am2814698350", db="droplet")

#Cursor Object
cur = db.cursor()

#place each row from MySQL in named tuple
queue_row = namedtuple('row_','sch_id dow start_time zone duration delay cancel_req cancel_conf')

#each named tuple is placed into a list
queue = []

dt = []


def today_date():
	today = date.today()
	today_data_ = today.timetuple()
	return today_data_

def today_time():
	time_now = datetime.now()
	return time_now	


def grab_schedule():
	cur.execute("SELECT * FROM schedule")

	for row in cur.fetchall():
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
		queue.append(queue_row(row[1], dow_, tmp[1], row[3], row[4], row[5], row[6], row[7]))





#Current Weather details
#cur_ref_time = obs_w.get_reference_time('date')
#cur_wind = obs_w.get_wind()                  # {'speed': 4.6, 'deg': 330}
#cur_humid = obs_w.get_humidity()              # 87
#cur_temp = obs_w.get_temperature('celsius')  # {'temp_max': 10.5, 'temp': 9.7, 'temp_min': 9.0}
#print("Time: "),
#print(cur_ref_time)
#print("Wind: "),
#print(cur_wind)
#print("Humidity: "),
#print(cur_humid)
#print("Temperature: "),
#print(cur_temp)



def proc_queue():
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
		print ", Cancel Req: ",
		if queue_row.cancel_req == 1:
			print "true"
		else:
			print "false"
		print ", Cancel Confirm: ",
		if queue_row.cancel_conf == 1:
			print "true"
		else:
			print "false"
		
		today_tuple_ = today_date()
		day_diff = abs(queue_row.dow - today_tuple_[6])
		#print "Day Diff: ",
		#print day_diff
		#print dt.time()
		time_ = re.split(':', queue_row.start_time)
		curr_time = today_time()
		hour_diff = abs(curr_time.hour - time_[1])
		 
		#print(today.isoformat() + " 12:00:00+00")
		if day_diff < 2 & hour_diff < 12:
			print "Scheduled watering within 24 hours: Days:",
			print day_diff,
			print " Hours: ",
			print hour_diff
			proc_rain()
			proc_temp(time_[1], time_[2])
			proc_wind()
		else:
			print "Scheduled watering not within 24 hours: Days:",
			print day_diff,
			print "Hours: ",
			print hour_diff


def proc_rain():
	for i in range (1, 8):
		#print(datetime.utcnow())
		dt = datetime.utcnow() + timedelta(hours=3*i)
		dt_ = dt.strftime('%Y-%m-%d %H:%M:%S') + "+00" 
		print(dt_)
		if(forc.will_be_rainy_at(dt_) == 1):
			print "Check Rainfall"
			rain_fall = obs_w.get_rain()
			if rain_fall[2] < 0.5: 
				print "Do not cancel (yet)"					
			else:
				return 1
		temp = obs_w.get_temperature(unit='celsius')
		print(temp)
		break
					
def proc_temp(hour, min):
	dt = datetime.utcnow()
	diff_hour = dt.hour - hour
	print diff_hour

def proc_wind():
	print "Processing Wind Data"

grab_schedule()	
proc_queue()

db.close()