# Setup api

1. xem provider để setup api
```terminal
php artisan install:api
```
2. trong usercontroller tạo fuction login để cấp token khi người dùng đăng nhập
3. bọc các route cần bảo vệ bằng middlware sanctum

# Dùng apis
1. đối với các api không được bảo vệ thì gọi bình thường
2. đối với các api được bọc bởi middleware sanctum xem api.php
- post :/api/login => để lấy token 
- khi request đến các route khác thì cần kèm bearer token

# Test (unit test phpunit)
1. tạo factory để chuẩn bị data test
2. gọi api lưu trong $response = $this->get(<api link>);
3. dùng các phương thức của PHPUnit để kiểm tra dữ liệu
-  kiểm tra status trả về từ server
```php
  $response->assertStatus(<status mong muốn>)
```
- Kiểm tra rằng dữ liệu JSON trả về có chứa các cặp key-value mong đợi
```php
$response->assertJson([[
    'id' => $book->id,
    'title' => $book->title,
]]);
```
- Kiểm tra rằng dữ liệu JSON trả về có số lượng phần tử đúng với giá trị mong đợi.
```php
$response->assertJsonCount(<số lượng>);
```
- Kiểm tra rằng bảng trong cơ sở dữ liệu có chứa một bản ghi khớp với dữ liệu chỉ định
```php
$this->assertDatabaseHas('books', [
    'title' => 'Test Title',
    'author' => 'Test Author',
    'price' => 10.50,
]);
//kiểm tra xem trong data base bảng books đã có dữ liệu trên chưa (không nhất thiết phải đầy đù)
```
- kiểm tra rằng bảng trong cơ sở dữ liệu không chứa bản ghi khớp với dữ liệu được chỉ định.
```php
$this->assertDatabaseMissing('books', ['id' => $book->id]);
//kiểm tra bảng books có đúng là không có dữ liệu id trên
```
- giả lập trạng thái của người dùng đang đăng nhập để thực hiện các yêu cầu có yêu cầu xác thực.
```php
$this->actingAs($user, 'sanctum');
// giả định người dùng đã xác thực sanctum thành công
```
- Bỏ qua việc thực thi một test hoặc toàn bộ test class.
```php
$this->markTestSkipped('Temporary Stop This Test Case...');
// đặt ở function setUp() để skip toàn class
```
