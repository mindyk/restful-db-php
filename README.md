restful-db-php
==============

This project aims to give you easy read access to your db by providing a restufall API to query it

#### example


GET http://www.yourproject.com/apidb/:db/:table?user_id=1

RESPONSE
```json
{
  "id": 1,
  "name": "Hans",
  "date-reg" : "2014-01-01 22:00:01"
}
```

GET http://www.yourproject.com/apidb/:db/:table?limit=2&order=id&fields=id,name

RESPONSE
```json
  [
    {
      "id": 1,
      "name": "Hans"
    },
    {
      "id": 2,
      "name": "Franz"
    }
  ]
```
  
