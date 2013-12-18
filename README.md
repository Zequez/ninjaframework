Ninja Framework
===============

This "framework", was created with the purpose of simplifying the organization of files within a frameworkless messy and small PHP project. It aims to be dead simple and not too serious. Under no circumstance use this for medium to big projects, you are going to have a bad time. You know what, just don't use it! Use [CodeIgniter](https://github.com/EllisLab/CodeIgniter/) or [CakePHP](https://github.com/cakephp/cakephp), or better, [Ruby on Rails](https://github.com/rails/rails), if you are willing to learn (always worth it).

Here we call things to be done "a lo ninja" when these are messy and with bad coding practices. Paradoxically, ninjas are silent and will kill you in the cleanest way possible. But the catchphrase was already here when I came.

It's also a tool for learning. And it's in spanish, I don't know why I'm writing this in english. But here everyone speaks spanish, and because is also a tool for learning I decided to do it in spanish.

Oh! I almost forgot, this project uses [Idiorm](https://github.com/j4mie/idiorm) and [Paris](https://github.com/j4mie/paris) for ORMing, so all the credits for that to them.

Tutorial
========

Cambiá las rutas en rutas.php

Cambiá la configuración de MySQL en config.php

Las rutas apuntan a la carpeta correspondienten en `/controladores`.

Se renderiza la vista con el mismo nombre que el controlador, pero en `/vistas`.
Si querés renderizar otra vista, devolvé el nombre de la vista en el return del controlador.

Todas las variables que definas en el controlador, serán accesibles desde la vista.

La vista se renderiza dentro de un layout. Por default es `/layouts/general.php`.

Si querés usar otro layout, llamá a `layout('nombre_del_layout')` en el controlador.

Para definir el lugar donde se renderiza la vista dentro del layout, simplemente hacer un `include $vista`

Tenés acceso a la constante `ROOT` para leer el root del sistema.

El "framework" ya viene con un ejemplo andando, así que modificá eso, es re boludo.

Con respecto a los modelos, ponelos en `/modelos` y se cargan solos. Usá [Idiorm](https://github.com/j4mie/idiorm) y [Paris](https://github.com/j4mie/paris) o lo que se te cante.




