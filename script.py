import requests
from bs4 import BeautifulSoup
import time
import json

cars = []
url = "https://www.autotrader.co.za"

headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 6.0) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/13.0.782.112 Safari/535.1"}
for page in range(1, 3860):
    response = requests.get(
        "https://www.autotrader.co.za/cars-for-sale?pagenumber=" + str(page), headers=headers)
    content = str(response.content)
    print("page %s" % page)
    
    while (content.find('{"resultType":1') != -1):
        firstLocation = content.find('{"resultType":1')
        
        lastLocation = content[firstLocation+1:].find('"isPOA":')+firstLocation
        
        if (content[lastLocation+9:lastLocation+14] == "false"):
            lastLocation = lastLocation+15
        else:
            lastLocation = lastLocation+14
        try:
            car = content[firstLocation:lastLocation].encode(
                "ascii", "ignore").decode("utf-8").replace('\\xc2\\xa0', "")
            cars.append(json.loads(car))
        except:
            pass
        content = content[lastLocation:]


with open("data2.json", "w") as outfile:
    json.dump(cars, outfile)
