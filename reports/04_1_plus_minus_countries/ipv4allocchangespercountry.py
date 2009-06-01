import adodb
from time import ctime, strftime, gmtime
conn = adodb.NewADOConnection('postgres')
conn.Connect('localhost', 'postgres', 'p', 'ip_stat')

outfile = file("ipv4datapercountry.csv", 'w')
day = 24 * 3600
week = 7 * day
inc = 4 * week # four weeks
t = 1041408000
end = 1238742000 #- inc # 1041408000 + 10 * inc april 3, 2009
while t < end:
    app = {}
    gmt = gmtime(t)
    if gmt.tm_mon == 12 and gmt.tm_mday > 5:
        t += day * (32 - gmt.tm_mday)
    gmt = gmtime(t)
    
    sql = "select count(*), name from (select ip, country from ipv4 where on_date='%s' group by country, ip except select ip,country from ipv4 where on_date='%s' group by country, ip) n left join countries on code2 = country group by name"%(ctime(t+inc),ctime(t))
    cursor = conn.Execute(sql)
    while not cursor.EOF:
        
        count, country = cursor.fields
        country = str(country)
        app[country] = count
#        print country, count
        cursor.MoveNext()
            
    
#    line = "%s,%d," % (strftime("%Y-%m-%d", gmt), cursor.fields[0])
    cursor.Close()
    dis = {}
    sql = "select count(*), name from (select ip, country from ipv4 where on_date='%s' group by country, ip except select ip,country from ipv4 where on_date='%s' group by country, ip) n left join countries on code2 = country group by name"%(ctime(t),ctime(t+inc))
    cursor = conn.Execute(sql)
    while not cursor.EOF:
        count, country = cursor.fields
        country = str(country)
        dis[country] = count
        cursor.MoveNext()
    
#    line += str(cursor.fields[0])
    cursor.Close()
    
    for a in app:
        if a not in dis:
            dis[a] = 0
    
    for d in dis:
        if d not in app:
            app[d] = 0
    line = ''    
    for a in app:
        line += strftime("%Y-%m-%d", gmt) + "\t" + a + "\t" + str(app[a]) + "\t" + str(dis[a]) + "\n"
    print >> outfile, line
    print line

    t += inc
conn.Close() 

outfile.close()