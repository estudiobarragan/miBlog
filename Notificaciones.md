## Creacion de Notificaciones

1. Crear notificaciones con db, para lo cual se necesita crear dicha tabla
   php artisan notifactions:table
   php artisan migrate
2. Crear la clase
   php artisan make:notification PostNotification

3. cambiar el metodo default de notificacion (mail)

    public function via($notifiable){
    return ['database'];
    }

4. Cargar el constructor de la clase con el agregado de los objetos que guardamos como publicos y que entra por parametro.
5. En el metodo toArray se debe generar el array de info que se guardara en la DB, es libre sobre lo que se quiera informar.
