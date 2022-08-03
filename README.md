<h1 align="center">CARDVIP.VN</h1>

<p align="center">
    <strong>Thư viện PHP để hỗ trợ sử dụng các API của cardvip.vn một cách nhanh chóng.</strong>
</p>

<p align="center">
    <a href="https://github.com/datlechin/cardvipvn-php"><img src="http://img.shields.io/badge/datlechin/cardvipvn--php-blue.svg?style=flat-square" alt="Source Code"></a>
    <a href="https://packagist.org/packages/datlechin/cardvipvn-php"><img src="https://img.shields.io/packagist/v/datlechin/cardvipvn-php.svg?style=flat-square&label=release" alt="Download Package"></a>
    <a href="https://php.net"><img src="https://img.shields.io/packagist/php-v/datlechin/cardvipvn-php.svg?style=flat-square&colorB=%238892BF" alt="PHP Programming Language"></a>
    <a href="https://github.com/datlechin/cardvipvn-php/blob/main/LICENSE"><img src="https://img.shields.io/packagist/l/datlechin/cardvipvn-php.svg?style=flat-square&colorB=darkcyan" alt="Read License"></a>
</p>

## Cài đặt

Bạn có thể sử dụng thư viện này bằng cách dùng Composer để cài đặt:

``` bash
composer require datlechin/cardvipvn-php
```

Hoặc nếu bạn không có Composer, hãy tải ZIP về giải nén và sử dụng tệp `CardVip.php`.

## Sử dụng

Khởi tạo đối tượng `$cardvip` để sử dụng các hàm hỗ trợ có sẵn:

```php
<?php
require_once 'vendor/autoload.php';

$cardvip = new \Datlechin\CardVipPHP\CardVip('DÁN_API_KEY_CỦA_BẠN_VÀO_ĐÂY');
```

### Gửi thẻ lên hệ thống

Sử dụng hàm `exchange()` trên đối tượng `$cardvip` đã tạo bên trên để gửi thẻ lên hệ thống cardvip.vn:

```php
$cardvip->exchange('VIETTEL', 20000, '12345678901234', '123456789012345', '123456789', 'https://tentrangweb.com/callback.php');
```

Gồm có 6 tham số:
- Tham số 1: Loại thẻ (VD: VIETTEL, MOBIFONE, VINAPHONE, VTC, GATE, VCOIN)
- Tham số 2: Mệnh giá (VD: 20000, 50000, 100000, 200000, 500000)
- Tham số 3: Số serial của thẻ
- Tham số 4: Mã thẻ
- Tham số 5: Request ID (mã ngẫu nhiên để đối chiếu kết quả gửi thẻ)
- Tham số 6: Đường dẫn callback (để nhận kết quả gửi thẻ)

#### Kết quả trả về:

Kết quả trả về là một chuỗi `json` có dạng như sau:

```json
{
    "status": "200",
    "message": "Thẻ đã được gửi đi"
}
```

Mặc định chế độ đổi thẻ là chế độ gạch thẻ có bảo hành, nếu bạn muốn đổi thành chế độ gạch thẻ không bảo hành có thể truyền `false` vào hàm `isFast()`:

```php
$cardvip->isFast(false);
$cardvip->exchange(...);
```

### Kiểm tra trạng thái của thẻ

Sử dụng hàm `checkCard()` trên đối tượng `$cardvip` đã tạo bên trên để kiểm tra trạng thái của thẻ:

```php
$cardvip->checkCard('123456789');
```

Tham số truyền vào là mã `request_id` mà bạn đã gửi lên lúc gửi thẻ.

Kết quả trả về là một chuỗi `json` có dạng như sau:

```json
{
  "status": "200", 
  "message": "Lấy thông tin thẻ thành công",
  "data": {
    "telco": "VIETTEL",
    "amount": 20000,
    "amount_received": 20000,
    "amount_customer_received": 20000,
    "serial": "123456789",
    "pin": "123456789",
    "status": 200,
    "request_id": "123456789",
    "created_at": "2020-01-01 00:00:00"
  }
}
```

## Liên kết

- Website: [ngoquocdat.com](https://ngoquocdat.com)
- Facebook: [Ngô Quốc Đạt](https://www.facebook.com/datlechinvn)
- Zalo: [Ngô Quốc Đạt](https://zalo.me/datlechin)
- Telegram: [Ngô Quốc Đạt](https://t.me/datlechin)