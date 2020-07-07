# Mengamankan file url dengan access ID memanfaatkan fitur Cache pada php Laravel

### cara menjalankan 

setting .env untuk database seperti biasa (gak ada settingan aneh aneh kok)

Jalankan beberapa command

```js
- composer install

- php artisan migrate
```


gunakan file postman yang sudah disediakan supaya enak kalo mau cobain


#### Penjelasan singkat

1. membuat data user / registrasi 
```js
POST : /api/Auth/CreateUser

BODY
{
    "email": "kuncoro@mail.com",
    "name": "Kuncoro Kunch",
    "password": "123456",
    "password_confirmation": "123456"
}


RESPONSE (200)
{
    "message": "success"
}

```

2. get access token
```js
POST : /api/Auth/GetAccessToken

BODY
{
    "email": "kuncoro@mail.com",
    "password": "123456"
}

RESPONSE (200)
{
    "data": {
        "access_token": "1|A5KOL3BGFNM4d6RIssdf1gq5G7vKKZts7xe1XNKUtT3y0y94iYecIi9No8QQuymlxZBBrQK7CApFdOIH"
    }
}

```

3. get data user profile
```js
GET : /api/User/GetProfile

RESPONSE (200)

{
    "data": {
        "id": 1,
        "name": "Kuncoro Kunch",
        "email": "kuncoro@mail.com",
        "files": {
            "avatar": [],
            "id_card": []
        },
        "original": {
            "id": 1,
            "name": "Kuncoro Kunch",
            "email": "kuncoro@mail.com",
            "email_verified_at": null,
            "created_at": "2020-07-07T08:15:04.000000Z",
            "updated_at": "2020-07-07T08:15:04.000000Z",
            "avatar_file_id": null,
            "id_card_file_id": null
        }
    }
}

```

4. Sekarang kita akan update file "avatar" dan "id_card" untuk profile user 

upload file yang akan digunakan terlebih dahulu dengan body Multipart/form-data
```js
POST: /api/Storage/Upload

"type" => "image"
"file" => [filenya]


RESPONSE (200)
{
    "data": {
        "url": null,
        "type": "image",
        "id": "1793d3a047864877b48c7cf0193f43ff1594110320"
    }
}
```

5. ketika udah mendapatkan response dari upload file, lalu gunakan ID file tersebut

```js
PATCH: /api/User/UpdateProfile

BODY
{
    "name": "Kuncoro Kunch Edited",
    "email": "kuncoro@mail.com",
    "avatar_file_id":  "1793d3a047864877b48c7cf0193f43ff1594110320",
    "id_card_file_id": "8d1bd28b372c490a8176ded024b660a31594110376"
}


RESPONSE (200)
{
    "message": "success"
}
```

6. Kemudian lihat data profile user lagi dengan hit endpoint yang sama seperti no.3

```js
{
    "data": {
        "id": 1,
        "name": "Kuncoro Kunch Edited",
        "email": "kuncoro@mail.com",
        "files": {
            "avatar": {
                "original": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=2fd7cd27bebc49aa9245adece3c5d8db1594110510",
                "xs": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=2fd7cd27bebc49aa9245adece3c5d8db1594110510&size=xs",
                "sm": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=2fd7cd27bebc49aa9245adece3c5d8db1594110510&size=sm",
                "md": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=2fd7cd27bebc49aa9245adece3c5d8db1594110510&size=md",
                "lg": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=2fd7cd27bebc49aa9245adece3c5d8db1594110510&size=lg"
            },
            "id_card": {
                "original": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=5893f4b76b7a43dc82e69a4133c0cb041594110510",
                "xs": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=5893f4b76b7a43dc82e69a4133c0cb041594110510&size=xs",
                "sm": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=5893f4b76b7a43dc82e69a4133c0cb041594110510&size=sm",
                "md": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=5893f4b76b7a43dc82e69a4133c0cb041594110510&size=md",
                "lg": "http://api-mypost.test/api/Storage/Retrieve/1793d3a047864877b48c7cf0193f43ff1594110320?access_id=5893f4b76b7a43dc82e69a4133c0cb041594110510&size=lg"
            }
        },
        "original": {
            "id": 1,
            "name": "Kuncoro Kunch Edited",
            "email": "kuncoro@mail.com",
            "email_verified_at": null,
            "created_at": "2020-07-07T08:15:04.000000Z",
            "updated_at": "2020-07-07T08:26:29.000000Z",
            "avatar_file_id": "1793d3a047864877b48c7cf0193f43ff1594110320",
            "id_card_file_id": "8d1bd28b372c490a8176ded024b660a31594110376"
        }
    }
}
```

kita akan mendapatkan data tambahan didalam object user yaitu "files" yang sudah disetting menggunakan Object Transformer

Selamat mencoba 









