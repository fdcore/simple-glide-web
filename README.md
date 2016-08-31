# Simple image web service for Glide & Slim

Простой веб сервис для раздачи изображений в разных размерах.

Например
```
/img/users/test.jpg?w=300&h=400&fit=crop
```

При указании такого URL будет выведена картинка **/img/users/test.jpg** с размерами 300x400.

Документация по параметрам <http://glide.thephpleague.com/1.0/api/quick-reference/>

## Цифровая подпись

Для защиты, вы можете использовать подпись ссылок. Это защитит от подмены параметров другими людьми.

Подробнее читайте на <http://glide.thephpleague.com/1.0/config/security/>.

Для включения защиты расскоментируйте строчку

```
SignatureFactory::create($signkey)->validateRequest($path, $_GET);
```

И укажите свой ключ в переменной `$signkey`.

Простая функция подписи:

```php
function sig_url($url)
{
  $signkey = '__YOUR_SECRET__';
  $data = parse_url($url);
  $full_url = $data['scheme'].'://'.$data['host'].$data['path'].'?'.$data['query'];
  $sig = md5($signkey.':'.ltrim($data['path'], '/').'?'.$data['query']);
  return $full_url.'&s='.$sig;
}
```
