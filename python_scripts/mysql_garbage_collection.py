import MySQLdb


db = MySQLdb.connect(host="localhost", port=3306, user="root", db="droplet")

cursor = db.cursor()

cursor.execute("SELECT ")