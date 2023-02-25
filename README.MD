# CARLDB

Programa escrito en php para administrar archivos csv desde la terminal de comandos.

El programa cuenta con los siguientes comandos: 


| Comando | Descripcion |
| ------ | ------ |
| help | Despliega un menú descriptivo de cada comando |
| autor | Imprime en pantalla informacion sobre los autores|
| list_tables | Retorna una lista con todas las tablas disponibles|
| select_table | Selecciona la tabla para posterior modificacion|
| create_table | Crea una tabla con los campos y tipo dado |
|exit| Finaliza la ejecucion del programa|

Despues de seleccionar una tabla se utilizan los siguientes comandos para su modificacion: 

| Comando | Descripcion |
| -------  | ---------- |
|insert |  Inserta una tupla |
|update | Actualiza los datos de una tupla |
|delete  | Remueve una tupla|
|select  | Lee un registro, a partir de un id o un filtro de busqueda como parametro |
|export| Exporta los datos de la tabla seleccionada|

