
## Base URL

```
http://127.0.0.1:8000/api
```

---

Authentication APIs

### Admin Login

**POST** `/admin/login`

### Seller Login

**POST** `/seller/login`



Admin APIs (Protected)

Get Sellers List

**GET** `/admin/seller`



Seller APIs (Protected)

### Create Product

**POST** `/seller/products`

### Delete Product PDF

**DELETE** `/seller/products/{id}/pdf`



All protected APIs require JWT token in header:


Authorization: Bearer {token}


* APIs secured using **JWT Authentication**
* Role-based access implemented (ADMIN / SELLER)
* Multipart form-data supported for product creation


