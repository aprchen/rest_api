URL Query Syntax

Query Parameters
fields
offset
limit
having
where
or
in
sort
Using parsed Query
Query Parameters

fields

The fields parameter allows you to include just the fields you need.
title,author
```$xslt
http://phalcon-rest-boilerplate.dev/items?fields=title,author
offset
```


The offset parameter allows you to exclude a given number of the first objects returned from a query. this is commonly used for paging, along with limit.
10
```$xslt
http://phalcon-rest-boilerplate.dev/items?offset=10

```

limit
The limit parameter allows you to limit the amount of objects that are returned from a query. This is commonly used for paging, along with offset.
100
```$xslt
http://phalcon-rest-boilerplate.dev/items?limit=10
having

```

author Is Equal 'Jake' AND likes Is Equal 10
{
    "author": "Jake",
    "likes": 10
}
```$xslt
http://phalcon-rest-boilerplate.dev/items?having={"author":"Jake","likes":10}
where
```


The where parameter lets you use conditionals
author Is Like Jake
{
    "author": {
        "l": "Jake"
    }
}
```$xslt
http://phalcon-rest-boilerplate.dev/items?where={"author":{"l":"Jake"}}
```

author Is Equal Jake
{
    "author": {
        "e": "Jake"
    }
}

```$xslt
http://phalcon-rest-boilerplate.dev/items?where={"author":{"e":"Jake"}}
```
author Is Not Equal Jake
{
    "author": {
        "ne": "Jake"
    }
}
```$xslt
http://phalcon-rest-boilerplate.dev/items?where={"author":{"ne":"Jake"}}
```
likes Is Greater Than 10
{
    "likes": {
        "gt": 10
    }
}
http://phalcon-rest-boilerplate.dev/items?where={"likes":{"gt":10}}
likes Is Less Than 10
{
    "likes": {
        "lt": 10
    }
}
http://phalcon-rest-boilerplate.dev/items?where={"likes":{"lt":10}}
likes Is Greater Than Or Equal To 10
{
    "likes": {
        "gte": 10
    }
}
http://phalcon-rest-boilerplate.dev/items?where={"likes":{"gte":10}}
likes Is Less Than Or Equal To 10
{
    "likes": {
        "lte": 10
    }
}
http://phalcon-rest-boilerplate.dev/items?where={"likes":{"lte":10}}
or

The or parameter allows you to specify multiple queries for an object to match in an array.
[
    {
        "author": {
            "e": "Jake"
        }
    }, {
        author: {
            "e": "Alex"
        }
    }
]
http://phalcon-rest-boilerplate.dev/items?or=[{"author":{"e":"Jake"}},{author:{"e":"Alex"}}]
in

The in parameter allows you to specify an array of possible matches.
{
    "author": [
        "Jake", 
        "Billy"
    ]
}
http://phalcon-rest-boilerplate.dev/items?in={"author":["Jake","Billy"]}
sort

The sort parameter allows you to order your results by the value of a property. The value can be 1 for ascending sort (lowest first; A-Z, 0-10) or -1 for descending (highest first; Z-A, 10-0).
Descending
{
    "likes": -1
}
http://phalcon-rest-boilerplate.dev/items?sort={"likes":-1}
Ascending
{
    "likes": 1
}
http://phalcon-rest-boilerplate.dev/items?sort={"likes":1}
Using parsed Query

query is a global object that contains a formatted query based on the urls query params.
Use the phqlQueryParser to automatically apply all the url query commands to a new phqlBuilder instance.
<?php

/** @var \PhalconRest\Data\Query $query */
$query = $this->get(Services::QUERY);

/** @var \PhalconRest\Data\Query\Parser\Phql $phqlQueryParser */
$phqlQueryParser = $this->get(Services::PHQL_QUERY_PARSER);

/** @var \Phalcon\Mvc\Model\Query\Builder $phqlBuilder */
$phqlBuilder = $phqlQueryParser->fromQuery($query);

// Resultset
$results = $phqlBuilder->getQuery()->execute();