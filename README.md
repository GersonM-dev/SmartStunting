# Smart Stunting API Documentation

**Base URL:**\
`https://smartstunting.dfxx.site/api`

---

## Authentication

### Register

**Endpoint:** `POST /register`\
Register a new user using phone number and password.

**Body:**

```
{
  "name": "John Doe",
  "phone": "08123456789",
  "password": "secret",
  "password_confirmation": "secret"
}
```

**Response:**

```
{
  "access_token": "...",
  "token_type": "Bearer"
}
```

---

### Login

**Endpoint:** `POST /login`\
Login using phone number and password.

**Body:**

```
{
  "phone": "08123456789",
  "password": "secret"
}
```

**Response:**

```
{
  "access_token": "...",
  "token_type": "Bearer"
}
```

---

### Logout

**Endpoint:** `POST /logout`\
**Headers:** `Authorization: Bearer {access_token}`

**Response:**

```
{
  "message": "Logged out"
}
```

---

## Anak (Children) API

All Anak endpoints require authentication (`Authorization: Bearer {token}`).

### List Anak

**GET /anak**

**Response:**

```
[
  {
    "id": 1,
    "user_id": 2,
    "name": "Budi",
    "gender": "male",
    "birth_date": "2020-01-01",
    "region": "Jakarta",
    "father_edu": "SMA",
    "mother_edu": "SMP",
    "user": { ... },
    "antropometry_records": [ ... ],
    "prediction_records": [ ... ]
  }
]
```

---

### Create Anak

**POST /anak**

**Body:**

```
{
  "name": "Budi",
  "gender": "male",
  "birth_date": "2020-01-01",
  "region": "Jakarta",
  "father_edu": "SMA",
  "mother_edu": "SMP"
}
```

**Response:**\
Returns the created object with relationships.

---

### Show Anak

**GET /anak/{id}**

Returns a single Anak with related user, antropometry\_records, and prediction\_records.

---

### Update Anak

**PUT /anak/{id}**

**Body:** *(any fields you want to update)*

---

### Delete Anak

**DELETE /anak/{id}**

---

## AntropometryRecord API

All AntropometryRecord endpoints require authentication.

### List Antropometry Records

**GET /antropometry-record**

Returns all records for the authenticated user, with related anak, predictionRecord, and user.

---

### Create Antropometry Record

**POST /antropometry-record**

**Body:**

```
{
  "anak_id": 1,
  "age_in_month": 36,
  "weight": 13.2,
  "height": 95.5,
  "vitamin_a_count": 2,
  "head_circumference": 48.3,
  "upper_arm_circumference": 15.4
}
```

**Response:**\
Returns the created record with relationships.

---

### Show Antropometry Record

**GET /antropometry-record/{id}**

---

### Update Antropometry Record

**PUT /antropometry-record/{id}**

**Body:** *(any fields you want to update)*

---

### Delete Antropometry Record

**DELETE /antropometry-record/{id}**

---

## PredictionRecord API

All PredictionRecord endpoints require authentication.

### List Prediction Records

**GET /prediction-record**

Returns all prediction records for the authenticated user, with anak, antropometryRecord, and user relations.

---

### Create Prediction Record

**POST /prediction-record**

**Body:**

```
{
  "anak_id": 1,
  "antropometry_record_id": 2,
  "status_stunting": "Normal",
  "status_underweight": "Normal",
  "status_wasting": "At risk",
  "recommendation": "Monitor monthly"
}
```

---

### Show Prediction Record

**GET /prediction-record/{id}**

---

### Update Prediction Record

**PUT /prediction-record/{id}**

**Body:** *(any fields you want to update, e.g. recommendation)*

---

### Delete Prediction Record

**DELETE /prediction-record/{id}**

---

## User API

All User endpoints require authentication (`Authorization: Bearer {token}`).

### Get Profile

**GET /user**

Returns the profile of the currently authenticated user.

**Response:**

```json
{
  "id": 2,
  "name": "John Doe",
  "phone": "08123456789",
  "email": "john@example.com"
  // ...other fields
}
```

---

### Update Profile

**PUT /user**

Update the authenticated user's information. Only send the fields you want to update.

**Body:**

```json
{
  "name": "New Name",
  "phone": "081212121212",
  "email": "new@email.com",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

**Response:**
Returns the updated user object.

---

### Delete Account

**DELETE /user**

Deletes the authenticated user account.

**Response:**

```json
{
  "message": "User deleted"
}
```

---

## Authentication Required

For all endpoints except `/register` and `/login`, set HTTP header:

```
Authorization: Bearer {access_token}
```

---

## HTTP Status Codes

- `200 OK`: Successful GET, PUT, DELETE
- `201 Created`: Successful POST
- `401 Unauthorized`: Authentication required or failed
- `404 Not Found`: Resource not found

---

## Example Usage (with cURL)

**Register:**

```
curl -X POST https://smartstunting.dfxx.site/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","phone":"08123456789","password":"secret","password_confirmation":"secret"}'
```

**Login:**

```
curl -X POST https://smartstunting.dfxx.site/api/login \
  -H "Content-Type: application/json" \
  -d '{"phone":"08123456789","password":"secret"}'
```

**Get Anak (with token):**

```
curl -X GET https://smartstunting.dfxx.site/api/anak \
  -H "Authorization: Bearer {access_token}"
```

---

## Contact & Support

For any issues, please contact your backend developer or open an issue in the project repository.

---

