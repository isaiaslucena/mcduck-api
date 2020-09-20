[![Build Status](https://travis-ci.org/isaiasneto/mcduck-api.svg?branch=master)](https://travis-ci.org/isaiasneto/mcduck-api)


![Scrooge McDuck](public/Scrooge_McDuck.png)

# mcduck-api

Currency converter API

## Available endpoints:

### Get currency list:

```
https://mcduck-api.herokuapp.com/api/currencyList
```


### Convert value:

Available digital currencies: **ADA, ATOM, BAT, BCH, BEST, BTC, CHZ, DASH, DOGE, EOS, ETC, ETH, KMD, LINK, LSK, LTC, MIOTA, NEO, OMG, ONT, PAN, QTUM, REP, TRX, USDC, USDT, VET, WAVES, XAG, XAU, XEM, XLM, XPD, XPT, XRP, XTZ, ZEC, ZRX**


Available normal currencies: **EUR, USD,CHF, GBP, TRY**


```
example: https://mcduck-api.herokuapp.com/api/currencyConvert?from=eur&to=eth&amount=847.68
```

### Get the last twenty converted operations:

```
https://mcduck-api.herokuapp.com/api/showConvertOperations
```


Staging environment: [https://mcduck-api.herokuapp.com](https://mcduck-api.herokuapp.com)

CI/CD: [https://travis-ci.org/github/isaiasneto/mcduck-api](https://travis-ci.org/github/isaiasneto/mcduck-api)

