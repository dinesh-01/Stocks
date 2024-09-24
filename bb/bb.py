import json
import requests
import pandas as pd
import pandas_ta as ta



url = "https://api.kite.trade/instruments/historical/17395202/30minute?from=2024-09-12+09:15:00&to=2024-09-18+15:30:00"

payload = {}
headers = {
  'X-Kite-Version': '3',
  'Authorization': 'token asx9hj1ykmv09kgc:SNgIzxhsWbNOV8rVdTNa9k4abmkZdfuP',
}

response = requests.request("GET", url, headers=headers, data=payload)
data  = json.loads(response.content)
datas = data['data']['candles']
my_list = []


for num in datas:
    my_list.append(num[4])


# Sample data: Create a DataFrame with some closing prices
data = {
    'close': my_list
}

df = pd.DataFrame(data)

# Calculate Bollinger Bands (by default, it uses a period of 20 and standard deviation of 2)
bollinger_bands = ta.bbands(df['close'], length=5, std=2)


# Add the Bollinger Bands (upper, middle, lower) to the original DataFrame
df = pd.concat([df, bollinger_bands], axis=1)

# Print the DataFrame with Bollinger Bands
print(df)


