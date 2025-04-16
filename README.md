# Arquitectura Hexagonal

En este proyecto se aplica varios conceptos fundamentales de diseño de software.

La arquitectura hexagonal, también conocida como arquitectura de puertos y adaptadores, permite desacoplar el núcleo de la aplicación de sus dependencias externas, facilitando la mantenibilidad y escalabilidad del proyecto.

Su objetivo es **evitar el acoplamiento** entre la **lógica de negocio** y las partes externas como la base de datos, servicios, APIs, frameworks, etc.

Se organiza en **tres partes principales**:

1. **Dominio (core del sistema)**: Contiene la lógica de negocio, es decir, las **entidades** y **casos de uso**.
2. **Puertos**: Son **interfaces** que definen **cómo se comunica el dominio con el exterior**, tanto para recibir información (puertos de entrada) como para enviar (puertos de salida).
3. **Adaptadores**: Son las **implementaciones concretas** de esos puertos. Se encargan de interactuar con el mundo externo, como la base de datos, servicios HTTP, interfaces de usuario, etc.

La capa de dominio permanece independiente del framework, la base de datos, APIs o cualquier tecnología externa.

Es fácil de testear porque se pueden crear mock sin necesidad de levantar servicios o base de datos reales.

> Puedes tener un sistema rápido y sin delays con arquitectura hexagonal, pero eso depende de cómo implementas los adaptadores y optimizas los recursos externos.

La arquitectura te da **flexibilidad, orden y control**. Tú eliges si lo usas para tener un sistema ágil y veloz

## Características del proyecto

-   Implementación básica de la arquitectura hexagonal.
-   Separación clara entre el dominio, los puertos y los adaptadores.

## Funcionalidades del Proyecto

-   Gestión de usuarios: creación, actualización y eliminación.
-   Validación de datos y reglas de negocio en el núcleo de la aplicación.
-   Creación, actualización y eliminación de usuarios.
-   Creación, actualización, eliminación y recuperación de productos.
-   Listado de productos.

## Instalación

Este proyecto está preparado para ejecutarse en un entorno Docker. Asegúrate de tener Docker

1. Construye y levanta los contenedores:
    ```bash
    docker-compose up --build
    ```
2. Accede al contenedor de la aplicación:
    ```bash
    docker exec -it hexagonal_app bash
    ```

El proyecto está desarrollado utilizando el framework Laravel

## Estructura del Proyecto

- /app/Features/{feature}/Domain**: Contiene las entidades y lógica de negocio.
- /app/Features/{feature}/Ports: Define los puertos.
- /app/Features/{feature}/Usecases:Define los casos de uso. 
- /app/Features/{features}/Infrastructure/Persistence: Implementa los adaptadores y la interacción con base de datos.

## Contribuciones

¡Las contribuciones son bienvenidas! Por favor, abre un issue o envía un pull request.
