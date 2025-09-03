# 📖 API Documentation

Base URL:

```bash
https://leoanggoro.my.id/project-api/
```

## 📌 Endpoint

```
| Method | Endpoint    | Description       |
| ------ | ----------- | ----------------- |
| GET    | /produk      | Get all items     |
| GET    | /produk/{id} | Get item by ID    |
| POST   | /add-produk      | Create a new item |
| PUT    | /update-produk/{id} | Update item by ID |
| DELETE | /delete-produk/{id} | Delete item by ID |
```

## 📦 Example: Raw JSON (POST /items)

```json
{
    "nama": "rambutan",
    "harga": "20000",
    "kategori": "buah",
    "image_url": "https://bibitbunga.com/wp-content/uploads/2015/05/rambutan-binjai.jpg"
}
```

## 🔧 How to Use (Local Setup)

1. Clone the Repository
```
git clone https://github.com/leoanggoro/php-rest-api.git
cd php-rest-api
```
2. Import the provided api_data.sql file into your MySQL database.
3. Configure Environment (.env)
```
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=api_data
```
