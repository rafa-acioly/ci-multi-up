# Multiplo upload com CI v3.+
<p>
  <a href="https://github.com/rafa-acioly/ci-multi-up/releases">
    <img src="https://img.shields.io/github/release/rafa-acioly/ci-multi-up.svg" alt="Release">
  </a>
</p>
## Como usar

Copie ou mova o arquivo MY_Upload para a pasta controllers `(application/controllers)`
Inclua a classe em seu controller
```php
require_once (dirname(__FILE__) . '/MY_Upload.php');

class YourClasse extends CI_Controller
{
  ...
```

Defina a chave usada em `$_FILES`
```php
$upload = new MY_Upload('yourKey', 'your_upload_path');
```

Inicie o upload
```php
$upload->initialize();
```

Caso o upload não ocorra o erro será armazenado em: `$upload->messageError`
```php
if (!$upload->initialize()) {
  echo $upload->messageError;
}
```
## Default

- Arquivos permitidos gif, png e jpg
- Nomes de arquivos criptografados

## Opcional

- Altere configurações com `$upload->configuration['upload_path] = 'your_upload_path'`
  - upload_path   (string)
  - allowed_types (string: 'gif|jpg|jpeg...')
  - encrypt_name  (true ou false)

## Como salvar os nomes dos arquivos no BD?

O atributo `fileNames` tera todos os nomes dos arquivos salvos na pasta.
```php
var_dump($upload->fileNames);
// Array ["fileencryptname.jpg", "fileencryptname.png", "fileencryptname.gif"];
// As extensões dos arquivos vão ser as mesmas do arquivo enviado para upload

$this->your_model->your_function($upload->fileNames);
```
