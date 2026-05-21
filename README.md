# Sistema de Gestión con Auditoría (Práctica Etapa 1)

Este proyecto es un sistema web robusto desarrollado en el framework Laravel (PHP). Implementa una arquitectura MVC con separación de roles, protección de rutas y un sistema automatizado de auditoría interna ("Caja Negra") a través de Traits para registrar de manera transparente el ciclo de vida de los modelos (creación, edición y eliminación de datos).

## 🌟 Características Clave
- **Control de Acceso y Roles:** División clara entre el Dashboard de usuario estándar y un Panel Administrativo VIP con enlaces condicionales dinámicos en la barra de navegación superior.
- **Sistema de Auditoría Automatizado:** Implementación del Trait `Auditable` que captura de forma automática: el usuario responsable de la acción, el modelo afectado (`Post`), el tipo de acción realizada (`create`, `update`, `delete`), los valores modificados (`old_values`, `new_values`), la dirección IP del cliente y su `User-Agent`.
- **Persistencia con Conversión Nativa:** Configuración de `casts` en el modelo `Audit` para transformar automáticamente arreglos de PHP a JSON en la base de datos de manera limpia y sin errores de conversión.
- **Localización Completa:** Configuración centralizada de la aplicación y generación de datos simulados (Faker) localizados al español de México (`es_MX`) junto con sincronización horaria local (`America/Mexico_City`).
- **Experiencia de Usuario (UX) Profesional:** Gestión multimedia optimizada (`enctype="multipart/form-data"`), carga de archivos adjuntos y alertas de validación integradas con Tailwind CSS.

## 🛠️ Requisitos Previos
Antes de desplegar el proyecto, asegúrate de tener configurado lo siguiente en tu entorno local:
- **PHP:** `^8.2` o superior
- **Composer:** Gestor de dependencias de PHP
- **Node.js & NPM:** Para la compilación de assets del frontend con Vite
- **Servidor de Base de Datos:** MySQL o SQLite corriendo activamente

## 🚀 Instrucciones de Instalación y Despliegue

Sigue este orden exacto de comandos en tu terminal para clonar y levantar el proyecto en tu máquina local:

1. **Clonar el repositorio y acceder a la carpeta del proyecto:**
   ```bash
   git clone [https://github.com/Diego715802/Practica1](https://github.com/Diego715802/Practica1)
   cd PracticaEtapa1