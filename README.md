# Debts
Plugin para recoger informacion de personas con deudas para bancos.

## Funciones
  - La información se guarda en una tabla.
  - Se uso WP_List_Table para mostrar la información en una tabla dinamica en el administrador de WP.
  - Para añadir y modificar la informacion es posible desde el panel de administración.
  - Para el usuario final se a creado 2 shorcode para recoger informacion.

## Usos
- El primer Shorcode recopila informacion y valida los valores desde un endpoint y se guarda la informacion en nuestra BD.
```sh
ShorCode
[debt redirect="http://google.com"]
```
- El segundo ShorCode recoge información y se guarda en nuestra base de datos.
```sh
ShorCode
[creditend redirect="http://google.com"]
```
- Ambos shorcode tienen un parametro para cuando el formulario se envia correctamente este redirigira a otra url. esta segunda url la pueden crear desde WP con un mensaje de agradecimiento.

## Instalacion

```sh
patch: wp-content/plugins/
git clone git@github.com:luisgagocasas/debts.git debts
cd debts
```

## Activar
```sh
Go url: /wp-admin/plugins.php
Activate "Plugin Deudas"
```

## Desarrollo
 - Luis Gago Casas
 - 

License
----

MIT