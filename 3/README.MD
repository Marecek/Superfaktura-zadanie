### Zadanie 3 -  PHP :
Napíšte prosím jednoduchú knižnicu (libku, ucelený blok kódu) na načítanie údajov firiem z českého registra spoločností. Nie je potrebné vytvárať používateľské rozhranie.

Vstupom metódy pre prácu s dátami má byť IČO. Formát výstupu metódy necháme na vás.

Endpoint pre údaje je:
<br> https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/{ICO}
<br>príklad volania
<br>https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/01569651

Skúste prosím kód vyšperkovať úplne najlepšie, ako dokážete (PHP 7.4+, ošetrenie vstupov, error handling, dokumentácia, formátovanie kódu...).

### Riešenie 3 :

#### Lokácia knižnice
```sh
'vendor/cobyid',
```

#### Použitie

```sh
use CoById\CoById;

$companyById = new CoById('{string:target_valid_url}');

#GET
$response = $companyById->getCompanyById('{string:ICO}')

#POST
$response = $companyById->getCompanyById('{string:ICO,array:data}')

#OUTPUT 
$json = $response->toJson();
$xml = $response->toXml();
$array = $response->toArray();
$object = $response->toObject();

```
*Príklad použitia v "index.php". - pozn. potrebný "composer install"  kvôli autoloadu tried v knižici* 

#### Možnosti:

```sh
#setRequestAllowedOrigin, default "*"
$companyById->setAllowedOrigin(string $allowedOrigin): void;

#setRequestTimeout in ms, default "15" mx
$companyById->setTimeout(int $timeout = 15): void;

#setConnectionTimeout in ms, default "10"
$companyById->setTimeout(int $timeout = 10): void;

#enableDisableSSL in ms, default "disabled"
$companyById->function enableSSL(): void;
$companyById->function disableSSL(): void;

#set Request user agent credential
$companyById->setAuthCredentials(string $username, string $password)void;

#set Request user agent credential, default "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0"
$companyById->setUserAgent(string $userAgent): void;

#manually trigger Request send
$companyById->send(): void;

#check if request has response
$companyById->hasResponse(): bool;

#return instance of Response class 
$companyById->getRequestResponse(): Response;

#Check if error
$response->getError();

#Get errors
$response->getErrors();

#set Default Request target url,"
$companyById->setUrl(string $providerUrl): void;

#set URL from which response should be recieved
$companyById->setResponseUrl(string $responseUrl): void;

```