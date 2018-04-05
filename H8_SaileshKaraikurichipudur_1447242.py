from dbconfig import *
import mysql.connector

#  Better use config.py for mysql parameters.
db = get_mysql_param()
cnx = mysql.connector.connect(user=db['user'], password=db['password'],
                              host=db['host'],
                              database=db['database'])
cursor = cnx.cursor()
query = '''
    SELECT Q1.Donor, Q1.`Total Paid`, Q2.Pocket FROM
    (SELECT CONCAT(A.FIRSTNAME, ' ', A.LASTNAME) AS 'Donor', SUM(B.AMOUNTPAID) AS 'Total Paid'
    FROM DONOR A, PLEDGE B
    WHERE A.DONORID = B.DONORID
    GROUP BY CONCAT(A.FIRSTNAME, ' ', A.LASTNAME)
    ORDER BY A.DonorId) AS Q1
    LEFT JOIN
    (SELECT CONCAT(A.FIRSTNAME, ' ', A.LASTNAME) AS 'Donor', SUM(C.AMOUNT) AS 'Pocket'
    FROM DONOR A, PLEDGE B, PAYMENT C
    WHERE A.DONORID = B.DONORID
    AND B.PLEDGEID = C.PLEDGEID
    AND C.COMPANYID IS NULL
    GROUP BY CONCAT(A.FIRSTNAME, ' ', A.LASTNAME)
    ORDER BY A.DonorId) AS Q2
    ON Q1.Donor = Q2.Donor;
'''

cursor.execute(query)

print("Donor\t\t\t\t\tTotal Paid\tPocket")
print("-----------------------------------------------------------------")
for (donor, total_paid, pocket) in cursor:
  print("{}\t\t\t\t${:,.0f}\t\t${:,.0f}".format(donor, total_paid, pocket))

cursor.close()
cnx.close()
