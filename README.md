# Iniciando o projeto

Após fazer o clone do projeto, realize o seguinte comando na raiz do projeto:
```
composer install
```

### Google Speech-to-text API

Feito isso, é necessário configurar a API do Google Speech-to-text para o correto funcionamento do projeto. Para mais informações sobre a api, acesse este [link](https://cloud.google.com/speech-to-text?hl=pt-br)

### Configurações

Como não estamos utilizando o .env, é necessário fazer algumas alterações no código.

Altere o arquivo send_mail.php, alterando a variável $destination:

![image](https://github.com/gabrielvsb/elastic_test/assets/53629458/d38486da-2e39-469b-ac3a-b96428beced7)


E também altere as credenciais para o envio de email:

![image](https://github.com/gabrielvsb/elastic_test/assets/53629458/39fa8ac4-4023-4ae5-81ed-27c4ba73905a)
