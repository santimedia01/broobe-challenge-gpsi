# Broobe Challenge - Google Page Speed Insights
#### Uso: Dejé un video en la raiz del proyeceto, para que se pueda apreciar todo 
## Pasos de Instalación
- Pre-configurar Node con NPM, MySQL y PHP 8.1 con composer.
- El proyecto ya viene con un .env
  - Configuramos el .env con las credenciales de la BD
    - En caso de no querer conectar una base de datos, realizar lo siguiente:
    - Seteamos DB_CONNECTION=sqlite
    - Creamos un archivo bd.sqlite en `.storage/bd.sqlite`
    - Seteamos DB_DATABASE="Ruta absoluta al archivo bd.sqlite" (recordar si el SO es Windows, escapar las barras en el string)
  - Configuramos en el .env la variable GOOGLE_PAGESPEEDONLINE_API_KEY="", que por las dudas no la hago pública en github de manera directa con el .env, por mas que ustedes le den de baja después. Se encontraba en el PDF del challenge, esta en `./.requeriments/Challenge_-_Laravel_PHP`.

- Ejecutamos los siguientes comandos:
  - `git clone https://github.com/santimedia01/broobe-challenge-gpsi` 
  - `cd broobe-challenge-gpsi`
  - `npm i`
  - `composer install`
  - `php artisan migrate --seed`
  - `php artisan storage:link`

## Pasos para server de desarrollo
- En consolas diferentes, ejecutar:
  - `npm run dev`
  - `php artisan serve`

## Dev Stack
- MacOS Ventura 13.6
- IDE: Jetbrains PHPStorm
- Servers:
  - Artisan Serve
  - Indigo (similar XAMPP, WAMP en MacOS) 
    - Apache 2.4.58
    - PHP 8.1.27
    - MySQL 8
- Aplicación:
  - Laravel 10.48
  - Blade + Vite
  - Tailwind
- El proyecto es Mobile & Desktop Ready.

### Aclaraciones varias
#### Proyecto
- Una de las primeras cosas que me puse a analizar era la cuestión del tiempo que tardaba el endpoint de la api de google. Al final tardo en promedio 30-50 segundos, pero ya estaba analizando la posibilidad de hacer la infraestructura de espera con Laravel Queues y Jobs. Esto más que nada porque las primeras URL que había probado algunas tardaron como 2 minutos y ya me estaba preocupando por como abarcar mejor el UX y tmb la solución. Tampoco quería hacer una sobre ingeniería sin sentido para esto.
- Sé que el challenge solicita crear tablas como las Categorías y Estrategias, pero en vez de esto, yo realizaría simplemente un Enum para ahorrar tiempo de ejecución, consultas a la BD innecesarias, etc. Supongo que esto es así por simple finalidad del challenge para obligarnos a realizar tablas y relacionarlas.
- Me habré ido del scope del Challenge seguro también, pero me gusta demostrar ideas.
- Suelo utilizar el "Patrón" Actions en Laravel, para almacenar allí los casos de uso y tener mejor organización. Claramente por tiempos y rapidez no lo realicé de manera estricta.
#### Tiempos
- Hay muchas cuestiones que se podrían mejorar/optimizar en la resolución de mi challenge, pero por cuestión de tiempos algunas decidí no realizarlas. No es que no sea capaz de ellas.
- Algunas, son mejorar la reusabilidad y separación en componentes del Blade. Siento muy importante este aspecto. Espero que no se note que vengo de la comodidad diaria de React.
- También hubiese estado bueno que me de el tiempo para hacer Feature Tests.
- Y haberle agregado también la screenshot que saca Lighthouse, que se recibe en la api como base64.
- Y mejorado varios puntos de las interfaces, supongo que se irá notando a medida que me quedaba sin tiempo, la reducción de calidad de las mismas.
- También entendí el requisito de que solo se guarde en BD en caso de que se solicite, pero no lo realicé así para ahorrarme un poco de js y poder renderizar con blade trayendo de la BD la vista de detalles del benchmark.
- Puedo hacer una arquitectura de front muchísimo mejor de la que está, esta medio un desastre, deje muchas cosas "colgadas" por tiempo
- Por mas que sea Full Stack, me gusta más el back, espero que tampoco se note tanto esa diferencia :) (Ya se que el codigo de Blade no quedo muy lindo, es cuestion de tiempos)
