# Products & payment pages

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

## Payment pages

```php
$response = $paymish->paymentPage()->create([
    'pageType' => 'Subscription',
    'pageName' => 'My Payment Page',
    'pageDescription' => 'Sample payment page',
    'planId' => 456,
]);

$response = $paymish->paymentPage()->list(['status' => 'Published', 'page' => 1, 'limit' => 10]);
$response = $paymish->paymentPage()->getDetails(1);
$response = $paymish->paymentPage()->checkCustomLink(['customLink' => 'my-page']);

$response = $paymish->paymentPage()->updateDetails([
    'pageId' => 1,
    'pageName' => 'Updated Page',
]);

$response = $paymish->paymentPage()->updateStatus([
    'pageId' => 1,
    'status' => 'Published',
]);

$response = $paymish->paymentPage()->addProduct([
    'pageId' => 1,
    'productId' => '123',
]);

$response = $paymish->paymentPage()->getProducts(1);
$response = $paymish->paymentPage()->getProducts(1, 'search term');

$response = $paymish->paymentPage()->deleteProduct([
    'pageId' => 1,
    'productId' => '123',
]);

$response = $paymish->paymentPage()->delete(['pageId' => 1]);
```

## Products

### CRUD

```php
$response = $paymish->product()->create([
    'productName' => 'Sample Product',
    'productDescription' => 'This is a sample product',
    'productPrice' => '100.00',
    'quantityType' => 'Limited',
    'quantityStock' => 100,
]);

$response = $paymish->product()->list(['page' => 1, 'limit' => 10]);
$response = $paymish->product()->getDetails('123');
$response = $paymish->product()->updateDetails([
    'productId' => '123',
    'productName' => 'Updated Product',
]);
$response = $paymish->product()->archive(['productId' => '123']);
$response = $paymish->product()->delete(['productId' => '123']);
$response = $paymish->product()->slugExist(['slug' => 'sample-product']);
```

### Media & inventory

```php
$response = $paymish->product()->uploadMedia('123', '/path/to/image.jpg');
$response = $paymish->product()->getMedia('123');
$response = $paymish->product()->deleteMedia(['productId' => '123', 'mediaId' => '...']);
$response = $paymish->product()->getInventoryDetails('123');
```

### Digital downloads

```php
$response = $paymish->product()->addDigitalDownloadFile('123', '/path/to/file.pdf');
$response = $paymish->product()->getDigitalDownloadFiles('123');
$response = $paymish->product()->renameDigitalDownloadFile([
    'productId' => '123',
    'fileId' => '...',
    'fileName' => 'new-name.pdf',
]);
$response = $paymish->product()->deleteDigitalDownloadFile([
    'productId' => '123',
    'fileId' => '...',
]);
$response = $paymish->product()->setDownloadLinkExpiry([
    'productId' => '123',
    'expiryDays' => 7,
]);
```

### Delivery fees

```php
$response = $paymish->product()->addDeliveryFees([
    'productId' => '123',
    'location' => 'Lagos',
    'fee' => 1500,
]);
$response = $paymish->product()->getDeliveryFees('123');
$response = $paymish->product()->updateDeliveryFees([/* ... */]);
$response = $paymish->product()->deleteDeliveryFees([/* ... */]);
```

### Discount codes

```php
$response = $paymish->product()->addDiscountCode([
    'productId' => '123',
    'code' => 'DISCOUNT20',
    'discountPercentage' => 20,
]);
$response = $paymish->product()->getDiscountCodes(['productId' => '123']);
$response = $paymish->product()->updateDiscountCodeDetails([/* ... */]);
$response = $paymish->product()->verifyDiscountCode([
    'productId' => '123',
    'code' => 'DISCOUNT20',
]);
```

See the [OpenAPI docs](https://api.paymish.com/api/user-service/external/v1/docs/) for full payload shapes.
