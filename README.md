Algunas instrucciones a tener en cuenta para la instalación:

1. Se ejecuta en local, con acceso a base de datos MySQL

2. Crear una Base de datos llamada "descom", ejecutando la instrucción sql de la carpeta /formulario-registro/sql/

3. El envío del email se realiza usando el objeto PHP. También he subido la libreria PHP Mailer que en ocasiones uso en caso de problemas con el spam

4. La contraseña indicada por el usuario, se codifica con SHA1 en la base de datos