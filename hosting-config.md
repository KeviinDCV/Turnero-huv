# Configuración para Hosting en la Nube - Videos de 500MB

## Archivos de Configuración para el Hosting

### 1. .htaccess (en la raíz del dominio)
```apache
# Configuración para archivos multimedia grandes
<IfModule mod_php.c>
    php_value upload_max_filesize 600M
    php_value post_max_size 600M
    php_value max_execution_time 600
    php_value max_input_time 600
    php_value memory_limit 512M
</IfModule>

# Para PHP-FPM (si se usa)
<IfModule mod_fcgid.c>
    FcgidMaxRequestLen 629145600
</IfModule>

# Configuración de Apache para archivos grandes
LimitRequestBody 629145600
```

### 2. .user.ini (en la raíz del dominio)
```ini
upload_max_filesize = 600M
post_max_size = 600M
max_execution_time = 600
max_input_time = 600
memory_limit = 512M
```

### 3. php.ini (si tienes acceso)
```ini
upload_max_filesize = 600M
post_max_size = 600M
max_execution_time = 600
max_input_time = 600
memory_limit = 512M
max_file_uploads = 20
```

## Cambios en el Código para 500MB

### 1. Controlador (TvConfigController.php)
```php
'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:512000', // 500MB max
```

### 2. JavaScript (tv-config.blade.php)
```javascript
const maxSize = 524288000; // 500MB en bytes
```

### 3. Mensajes de Error
```javascript
showUploadErrorModal('El archivo es demasiado grande. El tamaño máximo permitido es 500MB.');
```

## Instrucciones para el Hosting

1. Subir todos los archivos de configuración (.htaccess, .user.ini)
2. Cambiar los valores en el código de 40MB a 500MB
3. Verificar que el hosting soporte archivos grandes
4. Contactar al proveedor si es necesario aumentar límites

## Verificación

Crear un archivo test.php:
```php
<?php
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_execution_time: " . ini_get('max_execution_time') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";
?>
```
