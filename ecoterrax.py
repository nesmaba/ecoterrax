#!/usr/bin/python
#-*- coding: UTF-8 -*-
 
import MySQLdb
import serial
import time
 
# Establecemos la conexión con la base de datos
bd = MySQLdb.connect("localhost","root","root","ecoterrax" )
# Preparamos el cursor que nos va a ayudar a realizar las operaciones con la base de datos
cursor = bd.cursor()
 
#Inicia la comunicación con el puerto serie
PuertoSerie= serial.Serial('/dev/ttyACM0', 9600)
#Lectura de datos
sArduino = PuertoSerie.readline()
#Separa la cadena en valores, cada valor hasta la coma es almacenado en una variable
sIdHuerto,sHumHuerto,sTempAmbiente,sHumAmb,sEsRegado,basura=sArduino.split(',')
#print(sArduino.split(','))  #Devuelve 7 valores, el último es el salto de línea que no se almacena en una variable sino falla.

id = int(sIdHuerto)
hh = int(sHumHuerto)
ta = int(sTempAmbiente)
ha = int(sHumAmb)
esRegado = sEsRegado 
fecha = time.strftime("%Y-%m-%d")
hora= time.strftime("%H:%M:%S") #Formato de 24 horas

#Consultamos si el huerto con ese Id está ya dado de alta en nuestra base de datos
sqlSelect="SELECT * FROM Huerto WHERE IdHuerto=%d;" % (id)
try:
	rows_count = cursor.execute(sqlSelect)
	
	if(rows_count>0): #Existe el huerto. Solo actualizamos.
        	#sql="UPDATE Huertos SET humedad_huerto=%d, humedad_ambiente=%d, temperatura_ambiente=%d, total_riegos=%d WHERE idHuerto=%d;" % (hh,ha,ta,total,id)
		sql="INSERT INTO Medicion(tempAmb, humAmb, humTierra, fecha, hora, esRegado) values(%d,%d,%d,%s,%s,%s) WHERE idHuerto=%d;",  (ta,ha,ht,fecha,hora,esRegadp,id)
	else: #No existe el huerto con ese Id. Insertamos un nuevo huerto con un nuevo id
        	#sql="INSERT INTO Huertos(humedad_huerto, humedad_ambiente, temperatura_ambiente, total_riegos) VALUES (%d,%d,%d,%d);" %  (hh,ha,ta,total)
		sql="";
	try:
		print(sql)
		# Ejecutamos el comando
		cursor.execute(sql)
		bd.commit()
	except:
		print "Error Insertando/Actualizando la BD Huertos."
		bd.rollback()

except:
	print "Error consultado la BD."

#Nos desconectamos de la base de datos
bd.close()
