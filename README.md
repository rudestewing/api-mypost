<!-- # Mengamankan file url dengan access ID memanfaatkan fitur Cache pada php Laravel

### cara menjalankan 

setting .env untuk database seperti biasa (gak ada settingan aneh aneh kok)

Jalankan beberapa command

```js
- composer install

- php artisan migrate
```


gunakan file postman yang sudah disediakan supaya enak kalo mau cobain

[Download filenya disini](https://github.com/rudestewing/api-mypost/blob/master/mypost.postman_collection-1.json)

---

## Penjelasan singkat

### 1. membuat data user / registrasi 

`POST`
```js
/api/Auth/CreateUser
```

`BODY`
```js
{
    "email": "kuncoro@mail.com",
    "name": "Kuncoro Kunch",
    "password": "123456",
    "password_confirmation": "123456"
}

```
`RESPONSE`
```js
{
    "message": "success"
}

```

### 2. get access token

`POST`
```js
/api/Auth/GetAccessToken
```
`BODY`
```js
{
    "email": "kuncoro@mail.com",
    "password": "123456"
}
```
`RESPONSE`
```js
{
    "data": {
        "access_token": "1|A5KOL3BGFNM4d6RIssdf1gq5G7vKKZts7xe1XNKUtT3y0y94iYecIi9No8QQuymlxZBBrQK7CApFdOIH"
    }
}

```

### 3. get data user profile

`GET`
```js
/api/User/GetProfile
```

`RESPONSE`
```js
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

### 4. Update file "avatar" dan "id_card" untuk profile user 

upload file yang akan digunakan terlebih dahulu dengan body Multipart/form-data

`POST [multipart/form-data]`
```js
/api/Storage/Upload
```

`BODY`
```js
"type" => "image"
"file" => [filenya]
```

`RESPONSE`
```js
{
    "data": {
        "url": null,
        "type": "image",
        "id": "1793d3a047864877b48c7cf0193f43ff1594110320"
    }
}
```

Ketika sudah mendapatkan response dari upload file, gunakan ID file tersebut.

### 5. Update data user

`PATCH`
```js
/api/User/UpdateProfile
```
`BODY`
````js
{
    "name": "Kuncoro Kunch Edited",
    "email": "kuncoro@mail.com",
    "avatar_file_id":  "1793d3a047864877b48c7cf0193f43ff1594110320",
    "id_card_file_id": "8d1bd28b372c490a8176ded024b660a31594110376"
}
````

`RESPONSE`
```js
{
    "message": "success"
}
```

### 6. Kemudian lihat data profile user lagi dengan hit endpoint yang sama seperti no.3

`RESPONSE`
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

response akan mendapatkan data tambahan didalam object user yaitu "files" yang sudah disetting menggunakan Object Transformer.

value pada setiap files yang berupa url memiliki query parameter yaitu "access_id" yang telah di generate setiap kali dibutuhkan

".../api/Storage/Retrieve/...?access_id=5893f4b76b7a43...."

access_id tersebut berfungsi sebagai key supaya client dapat menerima response file dari server sebelum access_id tersebut expired

---

mungkin ini bukan Best Practice dalam pemanggilan file karena setiap kali mengakses endpoint "/api/Storage/Retrieve/{id}" server harus melakukan query untuk mendapat file yang dibutuhkan berdasarkan ID dari yang didapat dari parameter.

tapi disini fokus pada url file url yang tidak bisa sembarangan di akses karena akan ada waktu expired yang telah disetting pada Cache






 -->
