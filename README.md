# Mengamankan file url dengan access ID memanfaatkan fitur Temporary Signed URL pada laravel

### cara menjalankan 

setting .env untuk database seperti biasa (gak ada settingan aneh aneh kok)

Jalankan beberapa command

```js
- composer install

- php artisan migrate
```


gunakan file postman yang sudah disediakan supaya enak kalo mau cobain

[Download filenya disini](https://github.com/rudestewing/api-mypost/blob/master/mypost.postman_collection.json)

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
            "avatar_file": null,
            "id_card_file": null
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
        "path": "tp7Y0J3FHX9p14n9e8MRawUQ5I9z1qWp2Rkg91PD4JC.png",
        "url": {
            "original": "http://api-mypost.test/api/Storage/tp7Y0J3FHX9p14n9e8MRawUQ5I9z1qWp2Rkg91PD4JC.png?expires=1594143819&signature=36cb609ad3054b5a3903a38e9788008d66d43e1d547ee44b39c9789f4655667c"
        }
    }
}
```

Ketika sudah mendapatkan response dari upload file, selanjutnya gunakan Value pada path file yang telah didapat

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
    "avatar_file":  "1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png",
    "id_card_file": "1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png"
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
                "original": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&signature=b2b08ba8bbd1c5f21cd6790d95ae0110636a6fc9be3894eb786a5a4e45a9ac83",
                "xs": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=xs&signature=de8a6d17aa98d13aee581b5964fa090178454d705644d408f8b4edd3f5013e9c",
                "sm": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=sm&signature=c14e7afdf055f56fd245c83fb2d050fce9999cd28b32df2aa3b23fa557f4eac4",
                "md": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=md&signature=3b60abfd22264b7411ab86a5eba0a4a57b45a9e32ff4fdadde3ee02edffca5af",
                "lg": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=lg&signature=6fa8689a80a6472f8b5632262304f673f4e127273680eee5e6172478031cebaf"
            },
            "id_card": {
                "original": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&signature=b2b08ba8bbd1c5f21cd6790d95ae0110636a6fc9be3894eb786a5a4e45a9ac83",
                "xs": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=xs&signature=de8a6d17aa98d13aee581b5964fa090178454d705644d408f8b4edd3f5013e9c",
                "sm": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=sm&signature=c14e7afdf055f56fd245c83fb2d050fce9999cd28b32df2aa3b23fa557f4eac4",
                "md": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=md&signature=3b60abfd22264b7411ab86a5eba0a4a57b45a9e32ff4fdadde3ee02edffca5af",
                "lg": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=lg&signature=6fa8689a80a6472f8b5632262304f673f4e127273680eee5e6172478031cebaf"
            }
        },
        "original": {
            "id": 1,
            "name": "Kuncoro Kunch Edited",
            "email": "kuncoro@mail.com",
            "email_verified_at": null,
            "created_at": "2020-07-07T17:01:46.000000Z",
            "updated_at": "2020-07-07T17:03:35.000000Z",
            "avatar_file": "1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png",
            "id_card_file": "1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png",
            "files": {
                "avatar_file": {
                    "original": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&signature=b2b08ba8bbd1c5f21cd6790d95ae0110636a6fc9be3894eb786a5a4e45a9ac83",
                    "xs": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=xs&signature=de8a6d17aa98d13aee581b5964fa090178454d705644d408f8b4edd3f5013e9c",
                    "sm": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=sm&signature=c14e7afdf055f56fd245c83fb2d050fce9999cd28b32df2aa3b23fa557f4eac4",
                    "md": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=md&signature=3b60abfd22264b7411ab86a5eba0a4a57b45a9e32ff4fdadde3ee02edffca5af",
                    "lg": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=lg&signature=6fa8689a80a6472f8b5632262304f673f4e127273680eee5e6172478031cebaf"
                },
                "id_card_file": {
                    "original": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&signature=b2b08ba8bbd1c5f21cd6790d95ae0110636a6fc9be3894eb786a5a4e45a9ac83",
                    "xs": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=xs&signature=de8a6d17aa98d13aee581b5964fa090178454d705644d408f8b4edd3f5013e9c",
                    "sm": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=sm&signature=c14e7afdf055f56fd245c83fb2d050fce9999cd28b32df2aa3b23fa557f4eac4",
                    "md": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=md&signature=3b60abfd22264b7411ab86a5eba0a4a57b45a9e32ff4fdadde3ee02edffca5af",
                    "lg": "http://api-mypost.test/api/Storage/1SvA6JpZ48uBA58u306d1SIBYnKJo9GXzv4kvi1Z5F1.png?expires=1594143882&size=lg&signature=6fa8689a80a6472f8b5632262304f673f4e127273680eee5e6172478031cebaf"
                }
            }
        }
    }
}
```

response akan mendapatkan data tambahan didalam object user yaitu "files" yang sudah disetting menggunakan Object Transformer.

value pada setiap files yang berupa url adalah url yang telah di parsing menggunakan Temporary Signed URL jadi url tidak akan bisa di akses setiap saat karena memiliki waktu expired