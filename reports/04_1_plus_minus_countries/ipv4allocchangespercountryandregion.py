import adodb
from time import ctime, strftime, gmtime
conn = adodb.NewADOConnection('postgres')
conn.Connect('localhost', 'postgres', 'p', 'ip_stat')


day = 24 * 3600
week = 7 * day
inc = 365 * day # four weeks
t = 1041408000
lineNum = 1
linelist = []
end = 1238742000 #- inc # 1041408000 + 10 * inc april 3, 2009
while t < end:
    app = {}
    gmt = gmtime(t)
    if gmt.tm_mon == 12:
        t += day # leap years
    next = t + inc
    gmt = gmtime(next)
    if gmt.tm_mon == 12:
        next += day
    gmt = gmtime(t)
#    print gmt
    outfile = file("ipv4datapercountrywithregions%d.csv" % gmt.tm_year, 'w')
    sql = "select count(*), countries.name, world_regions.name, world_regions.id from (select ip, country from ipv4 where on_date='%s' group by country, ip except select ip,country from ipv4 where on_date='%s' group by country, ip) n left join (countries left join world_regions on region = world_regions.id) on code2 = country group by countries.name,world_regions.name,world_regions.id order by world_regions.id, countries.name"%(ctime(next),ctime(t))
    cursor = conn.Execute(sql)
    while not cursor.EOF:
        
        count, country, region, id = cursor.fields
        
        region = str(region)
        country = str(id) + "\t\""+region + "\"\t\"" + str(country) + "\""
        app[country] = count
        
#        print country, count
        cursor.MoveNext()
            
    
#    line = "%s,%d," % (strftime("%Y-%m-%d", gmt), cursor.fields[0])
    cursor.Close()
    dis = {}
    sql = "select count(*), countries.name, world_regions.name, world_regions.id from (select ip, country from ipv4 where on_date='%s' group by country, ip except select ip,country from ipv4 where on_date='%s' group by country, ip) n left join (countries left join world_regions on region = world_regions.id) on code2 = country group by countries.name,world_regions.name,world_regions.id order by world_regions.id, countries.name"%(ctime(t),ctime(next))
    cursor = conn.Execute(sql)
    while not cursor.EOF:
        count, country, region, id = cursor.fields
        region = str(region)
        country = str(id) + "\t\""+region + "\"\t\"" + str(country) + "\""
        
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
        linelist.append (a + "\t" + str(app[a]) + "\t" + str(dis[a]))# + "\n"
    linelist.sort()
    lineNum = 1
    for line in linelist:
        if line.find('None') == -1: 
            print >> outfile, str(lineNum) + "\t" + line
            lineNum += 1
    linelist = []
    outfile.close()
#    print >> outfile, line
#    print line
#    linelist.append(line)
    

    t += inc


    
    

    

conn.Close() 

