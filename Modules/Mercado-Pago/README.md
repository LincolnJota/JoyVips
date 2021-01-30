
# Mercado Pago - Módulo

O módulo do Mercado-Pago geralmente é usado na maior parte por brasileiros, então vou escrever isso em Português msm =D.


Se caso você for usar este módulo, eu recomendo fortemente que você use um gerador de senha e altere o nome do arquivo **response.php** [Clicando aqui](https://www.lastpass.com/pt/password-generator), pra facilitar sua vida!

Gere uma senha com os seguintes parâmetros:
- Número de caracteres: 20
- E a senha não pode conter símbolos.

## Fez o passo anterior? Então vamos lá!
Primeiro de tudo, crie um **Crie um banco de dados MySQL**.

Agora, dentro da pasta do módulo selecionado existe um arquivo chamado **config.php**.
Neste arquivo, você deve preencher o que se pede para que tudo funcione.
```
'acsstoken' => 'Sua credencial de produção',
'host' => 'localhost:3306',
'user' => 'usuário',
'pass' => 'senha',
'database' => 'vips', # Recomendo deixar desta forma.
```
##
### 1. Pegando as credenciais:
Acesse: https://www.mercadopago.com.br/developers/panel e crie uma aplicação, não tem dificuldade.

Após você criar e abrir, vá em: **Minhas Credenciais**.
Clicando nela, você deverá pegar o **Access Token** e colocar no arquivo **config.php**

Agora que você já tem o **banco de dados e o Access Token**:
hora de testarmos a conexão? Eu deixei um arquivo chamado **TesteDB.php** onde a única função é testar a conexão com o banco de dados. Abra ele em seu navegador e veja se ele retorna algo como ``Conexão bem sucedida com o banco de dados!`` Se sim, então vamos lá.
> Nota: O banco de dados tem que ser o mesmo configurado no servidor do minecraft.



### Após ter feito o teste, iremos para a **IPN**
>IPN é onde acontece o envio do **Mercado Pago** para seu site quando alguém realiza uma compra para poder salvar a key no banco de dados.

Lembra do arquivo **response.php** que eu falei pra você renomear gerando uma senha?
Então, ele será onde iremos receber as notificações do mercado pago.
**Acesse:** https://www.mercadopago.com.br/ipn-notifications
 - Em **URL para notificação** coloque onde tá o seu arquivo com nome gerado.
 - Desmarque todas as opções menos a **payment**, desta forma:
<img src="https://i.imgur.com/YL6wZzG.jpg"/>

##
### 2. Criando um produto VIP
Para criar um produto, você deve acessar o arquivo **products.php** e lá tem algo como:

```php
$preferenceItemOne  =  new MercadoPago\Preference(); //Sempre tem que criar uma preferência para cada item.

$itemOne  =  new MercadoPago\Item(); //Criando item..
$itemOne->title  =  'VipTest'; //Aqui deve ser o mesmo da config do minecraft.
$itemOne->quantity  =  1; // 1 é suficiente (por causa que é individual).
$itemOne->unit_price  =  20.00; // Aqui é o preço do vip.
$preferenceItemOne->items  =  array($itemOne);

$preferenceItemOne->save();
```
>Nota: Se você for criar outro vip,  renomeie a preferência, você vai entender no tópico abaixo.


##
### 3. Criando um botão no site.
Para que os seguintes códigos funcionem, seu site deve ter a extensão .php. Exemplo: **index.php**

Antes das tags ``<!DOCTYPE html>`` e ``<html>``
Você precisa incluir os produtos que você criou na sua página onde terá o botão de compra, dessa forma:
```php
<?php
	include("minhapasta/products.php");
?>
```
e para criar o botão, você basta usa JavaScript e PhP pra poder gerar o botão de acordo com seu produto.
```js
<script
  src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
  data-button-label="Buy VIP" data-preference-id="<?php echo $preferenceItemOne->id; ?>">
</script>
```
Onde tem ``$preferenceItemOne->id`` você altera somente a ``preferenceItemOne`` pela preferência que você fez ao criar cada produto em **products.php**. 

E Pronto! Seu site deve mostrar algo como: <img src="https://i.imgur.com/DRcR05b.jpg">


# !! AVISO URGENTE
### Para melhorar a segurança do seu site e bloquear invasores de descobrirem onde ficam sua IPN(Isso não pode acontecer)
Adicione isso em seu arquivo .htaccess nos arquivos do seu site, geralmente ele fica no memso local que seu index.php está.

```bash
RewriteCond %{HTTP_USER_AGENT} ^HTTrack [OR]
RewriteCond %{HTTP_USER_AGENT} ^SiteSucker [OR]
RewriteCond %{HTTP_USER_AGENT} ^WebZip [OR]
RewriteCond %{HTTP_USER_AGENT} ^WebCopier [OR]
RewriteCond %{HTTP_USER_AGENT} ^Zeus
RewriteRule ^.*$ no_download.html [L]
````

