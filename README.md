# Multple upload - CodeIgniter v3.+
<p>
  <a href="https://github.com/rafa-acioly/ci-multi-up/releases">
    <img src="https://img.shields.io/github/release/rafa-acioly/ci-multi-up.svg" alt="Release">
  </a>
</p>
## Como usar

Copy or move the `MY_Upload` file to your controller folder `(application/controllers)` and
include the file.
```php
require_once (dirname(__FILE__) . '/MY_Upload.php');

class YourClasse extends CI_Controller
{
  ...
```

Set the key `$_FILES`
```php
$upload = new MY_Upload('yourKey', 'your_upload_path');
```

Start the upload
```php
$upload->initialize();
```

Caso o upload não ocorra o erro será armazenado em: `$upload->messageError`
If the upload does not work, the error message will be in `$upload->messageError`
```php
if (!$upload->initialize()) {
  echo $upload->messageError;
}
```
## Default

- The file extension available are gif, png and jpg
- The file names are automatically encrypted.

## Optional

- Change the configuration using `$upload->configuration['upload_path] = 'your_upload_path'`
  - upload_path   (string)
  - allowed_types (string: 'gif|jpg|jpeg...')
  - encrypt_name  (boolean)

## How do i get the file names?

The attribute `fileNames` will store all the names.
```php
var_dump($upload->fileNames);
// Array ["fileencryptname.jpg", "fileencryptname.png", "fileencryptname.gif"];
// The file extension keep the same as the original file.

$this->your_model->your_function($upload->fileNames);
```

## Still don't get it?

- [See the example folder](https://github.com/rafa-acioly/ci-multi-up/tree/master/example)


## FAQ

- How I define my own prefix instead of using `MY_`?
  - see the documentation of codeigniter - [Setting Your Own Prefix](http://www.codeigniter.com/user_guide/general/core_classes.html?highlight=my_#setting-your-own-prefix)