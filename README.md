# Multiplo upload com CI v3.+

[![Code Climate](https://codeclimate.com/github/rafa-acioly/multiple-upload-CI/badges/gpa.svg)](https://codeclimate.com/github/rafa-acioly/multiple-upload-CI)

## Como usar

1. Copie o arquivo controller para sua pasta de controllers.
2. Inclua a função `hasFile` na classe `Upload` - [linha 1324](https://github.com/rafa-acioly/multiple-upload-CI/blob/master/system/libraries/Upload.php#L1324) - *você pode também copiar esta função a incluir diretamente no controller para evitar mecher no core do framework*
3. Defina a chave que ira usar em `$_FILES`
4. Defina as configurações de validação pra os arquivos enviados - *veja todas as configurações na [documentação do codeigniter](https://www.codeigniter.com/user_guide/libraries/file_uploading.html#preferences)*

Crie um formulario direcionando os dados para a classe `upload` usando a função `config_upload`

```PHP
<?php form_open_multipart('upload/do_upload'); ?>
  <input type="file" name="userFile[]" multiple />
  <input type="submit" value="Enviar" />
<?php form_close(); ?>
```

## Como salvar no BD?

O atributo `$this->fileNames` tera todos os nomes dos arquivos salvos na pasta.
