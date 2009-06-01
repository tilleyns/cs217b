from compiler.ast import Add
import adodb
from time import ctime, strftime, gmtime
conn = adodb.NewADOConnection('postgres')
conn.Connect('localhost', 'postgres', 'p', 'ip_stat')


outfile = file("ipv4data.csv", 'w')
day = 24 * 3600
week = 7 * day
inc = 4 * week # four weeks
t = 1041408000
add_total = 0
sub_total = 0
end = 1238742000 #- inc # 1041408000 + 10 * inc april 3, 2009
while t < end:
    gmt = gmtime(t)
    if gmt.tm_mon == 12 and gmt.tm_mday > 5:
    	t += day * (32 - gmt.tm_mday)
    gmt = gmtime(t)
    
    sql = "select count(*) from (select ip from ipv4 where on_date='%s' except select ip from ipv4 where on_date='%s') duck"%(ctime(t+inc),ctime(t))
    cursor = conn.Execute(sql)
    
    add_total += cursor.fields[0]
    line = "%s\t%d\t" % (strftime("%Y-%m-%d", gmt), cursor.fields[0])
    line += str(add_total) + '\t'
    cursor.Close()
    sql = "select count(*) from (select ip from ipv4 where on_date='%s' except select ip from ipv4 where on_date='%s') duck"%(ctime(t),ctime(t+inc))
    cursor = conn.Execute(sql)
    line += str(cursor.fields[0]) + '\t'
    sub_total += cursor.fields[0]
    line += str(sub_total)
    
    cursor.Close()
    print >> outfile, line
    print line

    t += inc
conn.Close() 

outfile.close()
