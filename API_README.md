## Veterinary Practice System API

## Base URL
`https://wildlifesupreme.developme.space/api/`

## Authentication

In order to use the service you'll need to have an account created for you. Email me at nosvalds@gmail.com and I'll get you set up.

Once you have the account information, make the following request to recieve a Bearer Token:

`POST https://wildlifesupreme.developme.space/oauth/token`

### Request

```json
{
    "grant_type": "password",
    "client_id": "<your_client_id>",
    "client_secret": "<your_client_secret>",
    "username": "your_username@example.com",
    "password": "password"
}
```

### Response

```json
{
    "token_type": "Bearer",
    "expires_in": 31535999,
    "access_token": "...",
    "refresh_token": "..."
}
```

### Usage

You'll need to use your token for all requests.

For example, if your response was:

```json
{
    "token_type": "Bearer",
    "expires_in": 31535999,
    "access_token": "massivelylongaccesstoken",
    "refresh_token": "..."
}
```

All your requests should have the following header:

```
Authorization: Bearer massivelylongaccesstoken
```


## Owners

### `GET /owners`

Will return a list of all animal owners, their details, and the animals they own.

```json
{
    "data": [
        {
            "id": 1,
            "name": "Helena Beahan",
            "address": "Adah Villages, Suite 833, West Hudson, 52447-8504",
            "animals": [
                "Dr. Destiny Crist",
                "Hardy Luettgen",
                "Doogo"
            ]
        },
        {
            "id": 2,
            "name": "Grayce Graham",
            "address": "Dicki Vista, Apt. 837, Lake Elouiseport, 14515-7225",
            "animals": [
                "Felipe Walsh Sr.",
                "Nyasia Reynolds",
                "Dr. Dina Fadel PhD"
            ]
        },
    ]
}
```

### `POST /owners`

Will create a new owner

#### Request

```json
{	
    "first_name": "<first name>", // REQ - String
    "last_name" : "<last name>", // REQ - String
    "address_1": "<address_1>", // REQ - String
    "address_2": "<address_2>", // REQ - String
    "town": "<town>", // REQ - String
    "telephone": "+XXXXXXXXXXX", // REQ - String
    "postcode": "<postcode>", // REQ - String
    "user_id": {id} // // REQ - integer creating user, 
}
```

### `GET /owners/<id>`

Will return an owner with the given `id`.
 
```json
{
        "id": 1,
        "name": "Helena Beahan",
        "address": "Adah Villages, Suite 833, West Hudson, 52447-8504",
        "animals": [
            "Dr. Destiny Crist",
            "Hardy Luettgen",
            "Doogo"
        ]
}
```

### `PUT /owners/<id>`

Will update an existing owner. 

#### Request

Use the same request format as `POST /owners`.

### `DELETE /owners/<id>`

Will delete an existing owner


## Animals

### `GET /animals`

Will return a list of all animals and their details.

```json
{
    "data": [
        {
            "id": 1,
            "name": "Ludwig Walter",
            "dob": "1974-12-29",
            "weight": 76.47,
            "height": 283.58,
            "biteyness": 3,
            "owner": "Christ Williamson",
            "treatments": [
                "Neuter",
                "de-clawing",
                "spay"
            ]
        },
        {
            "id": 2,
            "name": "Felipe Walsh Sr.",
            "dob": "1979-10-06",
            "weight": 129.47,
            "height": 367.74,
            "biteyness": 1,
            "owner": "Grayce Graham",
            "treatments": [
                "spay",
                "spay",
                "shaving"
            ]
        },
    ]
}
```

### `POST /animals`

Will create a new animal. Similar to using `POST /owners/<id>/animals`, but in this case you must include the owner_id in the request.

#### Request

```json
{	
    "name": "<animal name>", // REQ - string
    "date_of_birth": "YYYY-MM-DD", // REQ - date
    "type": "<type of animal>", // REQ - string
    "weight": n.nn, // REQ - float in kg
    "height": n.nn, // REQ - float in cm
    "biteyness": n, // REQ - integer 1-5
    "owner_id": int, // REQ - owner ID
    "treatments": ["treatment 1", "treatment 2"] // OPT - array of strings
}
```

### `GET /animals/<id>`

Will return an animal with the given `id`.
 
```json
{
    "data": {
        "id": 5,
        "name": "Chloe Raynor",
        "dob": "1988-10-05",
        "weight": 175.61,
        "height": 495.78,
        "biteyness": 5,
        "owner": "Arvel Bauch",
        "treatments": [
            "de-clawing",
            "Neuter",
            "Toenail Removal"
        ]
    }
}
```

### `PUT /animals/<id>`

Will update an existing owner. 

#### Request

Use the same request format as `POST /animals`.

### `DELETE /animals/<id>`

Will delete an existing animal

## Animals and Owners

### `GET /owners/<id>/animals`

Get the animals for an owner

### Response
```json
{
    "data": [
        {
            "id": 39,
            "name": "Dr. Destiny Crist",
            "dob": "2011-02-20",
            "weight": 33.39,
            "height": 86.05,
            "biteyness": 2,
            "owner": "Helena Beahan",
            "treatments": [
                "Flea Treatment",
                "spay",
                "petting therapy"
            ]
        },
        {
            "id": 82,
            "name": "Hardy Luettgen",
            "dob": "2015-09-01",
            "weight": 185.6,
            "height": 16.07,
            "biteyness": 5,
            "owner": "Helena Beahan",
            "treatments": [
                "petting therapy",
                "shaving",
                "petting therapy"
            ]
        },
        {
            "id": 101,
            "name": "Doogo",
            "dob": "2020-01-01",
            "weight": 4,
            "height": 12,
            "biteyness": 2,
            "owner": "Helena Beahan",
            "treatments": []
        }
    ]
}
```

### `POST /owners/<id>/animals`

Add a new animal to an owner

#### Request

```json
{	
    "name": "<animal name>", // REQ - string
    "date_of_birth": "YYYY-MM-DD", // REQ - date
    "type": "<type of animal>", // REQ - string
    "weight": n.nn, // REQ - float in kg
    "height": n.nn, // REQ - float in cm
    "biteyness": n, // REQ - integer 1-5
    "treatments": ["treatment 1", "treatment 2"] // OPT - array of strings
}
```