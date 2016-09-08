# Multiplo upload com CI v3.+

## Como usar

1. Copie ou mova o arquivo MY_Upload para a pasta controllers `(application/controllers)`
2. Inclua a classe em seu controller
```php
require_once (dirname(__FILE__) . '/MY_Upload.php');

class YourClasse extends CI_Controller
{
  ...
```
3. Defina a chave usada em `$_FILES`
```php
$upload = new MY_Upload('yourKey', 'your_upload_path');
```
4. Inicie o upload
```php
$upload->start(); // Inicia o upload
```

## Default

- Arquivos permitidos gif, png e jpg
- Nomes de arquivos criptografados

## Opcional

- Todos os nomes dos arquivos salvos serão armazenados em `$upload->fileNames`
- Altere configurações com `$upload->configuration['upload_path] = 'your_upload_path'`
  - upload_path   (string)
  - allowed_types (string: 'gif|jpg|jpeg...')
  - encrypt_name  (true ou false)

## Como salvar no BD?

O atributo `$this->fileNames` tera todos os nomes dos arquivos salvos na pasta.
