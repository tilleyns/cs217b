
import sys

from compiler.ast import Add
import adodb
from time import ctime, strftime, gmtime
conn = adodb.NewADOConnection('postgres')
conn.Connect('localhost', 'postgres', 'p', 'ip_stat')


#outfile = file("ages.csv", 'w')
#day = 24 * 3600
#week = 7 * day
#inc = 4 * week # four weeks
#t = 1041408000
#add_total = 0
#sub_total = 0
#end = 1238742000 #- inc # 1041408000 + 10 * inc april 3, 2009
#while t < end:
#gmt = gmtime(t)
#if gmt.tm_mon == 12 and gmt.tm_mday > 5:
#	t += day * (32 - gmt.tm_mday)
#gmt = gmtime(t)

sql = "select age,count(*) from bgp_ages where source="+sys.argv[1]+" group by age order by age"
cursor = conn.Execute(sql)
while not cursor.EOF:
    age, count = cursor.fields
    #print >> outfile, 
    print str(age) + "\t" + str(count)
    cursor.MoveNext()
cursor.Close()

conn.Close() 

#outfile.close()
