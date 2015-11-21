NET STOP wampapache64
.\bin\apache\apache2.4.9\bin\httpd.exe -k uninstall -n wampapache64
NET STOP wampmysqld64 
.\bin\mysql\mysql5.6.17\bin\mysqld.exe --remove wampmysqld64
wampmanager.exe -quit -id={wampserver}