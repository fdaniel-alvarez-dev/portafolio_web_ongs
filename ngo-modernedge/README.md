# Guía de Despliegue para NGO-ModernEdge

Esta guía proporciona instrucciones detalladas para el despliegue de la plataforma NGO-ModernEdge, diseñada específicamente para organizaciones no gubernamentales que buscan modernizar su infraestructura tecnológica.

---

## 1. Requisitos Previos

Antes de comenzar el despliegue, asegúrate de contar con lo siguiente:

- **Servidor** con sistema operativo Linux (Ubuntu 20.04 LTS recomendado).
- **Docker** y **Docker Compose** instalados.
- Mínimo **4GB RAM** y **2 CPUs**.
- **Dominio configurado** con registros DNS apuntando al servidor.
- **Certificado SSL**, recomendado usar Let's Encrypt.

---

## 2. Configuración del Entorno

Para preparar el entorno de despliegue:

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/ngo-modernedge/platform.git
   ```
2. Crear un archivo `.env` con las variables de entorno necesarias.
3. Configurar:
   - Credenciales de base de datos.
   - Servicios externos.
   - URL del sitio y parámetros de correo electrónico.

---

## 3. Instalación

Sigue estos pasos para instalar la plataforma:

1. **Construir las imágenes**:
   ```bash
   docker-compose build
   ```
2. **Iniciar los servicios**:
   ```bash
   docker-compose up -d
   ```
3. Ejecutar migraciones de base de datos:
   ```bash
   docker-compose exec app python manage.py migrate
   ```
4. Crear un superusuario:
   ```bash
   docker-compose exec app python manage.py createsuperuser
   ```

---

## 4. Configuración de Seguridad

Para garantizar un entorno seguro:

- Configurar firewall (permitir puertos 80 y 443).
- Instalar y configurar Let's Encrypt para HTTPS.
- Configurar cabeceras de seguridad en el servidor web.
- Implementar una política de contraseñas seguras.

---

## 5. Mantenimiento

Para el mantenimiento continuo de la plataforma:

- Configurar copias de seguridad automáticas.
- Establecer monitoreo del sistema.
- Procedimiento de actualización:
   ```bash
   git pull && docker-compose down && docker-compose build && docker-compose up -d
   ```
- Rotación de logs y gestión de almacenamiento.

---

## 6. Integración con Arquitectura Headless

Esta plataforma también puede utilizarse como arquitectura headless, separando frontend (React/Next.js) y backend (WordPress).

### 6.1 Requisitos Previos

- **Node.js** v18+.
- Docker y Docker Compose instalados.
- Git.
- Cuentas en:
  - **Vercel** (para despliegue del frontend).
  - **SiteGround** o proveedor similar (para hosting de WordPress).
- **Dominio configurado** con registros DNS.
- Conocimientos en WordPress Headless y GraphQL.

---

## 6.2 Configuración del Entorno

Para preparar el entorno de desarrollo:

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/your-org/ngo-modernedge.git
   cd ngo-modernedge
   ```
2. Iniciar el entorno WordPress con Docker:
   ```bash
   docker-compose up -d
   ```
3. Instalar dependencias del frontend:
   ```bash
   cd frontend-react
   npm install
   ```
4. Crear un archivo `.env.local` en la carpeta `frontend-react` con:
   - URL de la API WordPress.
   - Credenciales para autenticación JWT.
   - Variables de entorno específicas.

---

## 6.3 Instalación

### Backend (WordPress Headless)

1. Accede al panel de administración de WordPress.
2. Instala y activa los siguientes plugins:
   - WPGraphQL.
   - Advanced Custom Fields.
   - JWT Authentication.
   - Wordfence (seguridad).
3. Configura:
   - Tipos de contenido personalizados.
   - Esquema GraphQL.

### Frontend (Next.js)

1. Configura la conexión con la API WordPress en los archivos correspondientes.
2. Verifica el correcto funcionamiento:
   ```bash
   npm run dev
   ```
3. Construye la aplicación para producción:
   ```bash
   npm run build
   ```

---

## 6.4 Configuración de Seguridad

- Configura Wordfence en WordPress como firewall de aplicación.
- Habilita HTTPS en ambos entornos con certificados SSL.
- Implementa autenticación JWT para comunicación segura entre frontend y backend.
- Configura límites de tasa (rate limiting) para prevenir abusos de la API.
- Configura cabeceras de seguridad en ambos entornos.

---

## 7. Despliegue en Producción

### WordPress (Backend)

- Configura WordPress en SiteGround u otro proveedor especializado.
- Instala todos los plugins necesarios.
- Configura Redis para caché de respuestas API.
- Establece políticas de seguridad y firewall.

### Next.js (Frontend)

- Conecta el repositorio con Vercel.
- Configura las variables de entorno en el panel de Vercel.
- Despliega usando CI/CD automático a través de GitHub Actions.

### Configuración DNS

- Apunta subdominios según la arquitectura:
  - `api.tudominio.org` → WordPress.
  - `tudominio.org` → Frontend en Vercel.

---

## 8. Optimización y Monitoreo

Para mantener los KPIs garantizados:

- Configura monitoreo para mantener Lighthouse Score > 90.
- Implementa estrategia de caché para soportar 10K+ usuarios concurrentes.
- Configura alertas de rendimiento y disponibilidad.
- Establece procedimientos de respaldo automático para:
  - Base de datos WordPress.
  - Código fuente.
  - Archivos multimedia.

---

## 9. Mantenimiento Continuo

- Actualiza regularmente dependencias del frontend.
- Mantén WordPress y los plugins actualizados.
- Monitorea logs y métricas de rendimiento.
- Procedimiento de actualización:

### Backend:
   ```bash
   wp-cli core update && wp-cli plugin update --all
   ```

### Frontend:
   ```bash
   git pull
   npm install
   npm run build
   ```
   O simplemente realiza un push a GitHub para el despliegue automático.
