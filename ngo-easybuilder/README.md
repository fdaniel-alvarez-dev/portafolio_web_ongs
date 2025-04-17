# WordPress Optimizado para ONGs

## Introducción

Este proyecto proporciona una solución WordPress optimizada específicamente para las necesidades de Organizaciones No Gubernamentales (ONGs). Combina la potencia y flexibilidad de WordPress con personalizaciones y mejores prácticas orientadas a maximizar el impacto de la presencia digital de organizaciones sin fines de lucro.

## Características Principales

- **Rendimiento optimizado**: Configuraciones preestablecidas para garantizar tiempos de carga rápidos incluso con recursos limitados
- **Accesibilidad mejorada**: Cumplimiento de estándares WCAG para llegar a la audiencia más amplia posible
- **Plantillas específicas para ONGs**: Diseños predefinidos para campañas, donaciones, eventos y voluntariado
- **Integración con herramientas de recaudación**: Compatibilidad con plataformas populares de donaciones
- **Seguridad reforzada**: Protecciones adicionales para datos sensibles de donantes y voluntarios
- **SEO orientado a causas sociales**: Optimizaciones para mejorar la visibilidad de proyectos sociales

## Requisitos

- PHP 7.4 o superior
- MySQL 5.6 o superior / MariaDB 10.1 o superior
- Servidor web (Apache, Nginx)
- Al menos 256MB de memoria PHP asignada

## Instalación

1. Descarga la última versión desde [wordpress]([https://github.com/ejemplo/wordpress-ong/releases](https://wordpress.org/download/releases/6-5/))
2. Descomprime el archivo en tu servidor web
3. Crea una base de datos MySQL para tu instalación
4. Visita la URL del sitio en tu navegador y sigue el asistente de instalación
5. Durante la configuración, selecciona el perfil "ONG" para activar las optimizaciones específicas

## Plugins Recomendados

Esta distribución incluye plugins esenciales para ONGs:

- **Give** - Sistema de donaciones y gestión de donantes
- **The Events Calendar** - Organización de eventos y voluntariado
- **Yoast SEO** - Optimización para motores de búsqueda
- **Really Simple SSL** - Seguridad de conexiones
- **UpdraftPlus** - Copias de seguridad automatizadas

## Personalización

A continuacion alguns puntos importantes referentes a la personalización:

- Personalizar la apariencia según la identidad de tu organización
- Configurar formularios de donación y campañas de recaudación
- Optimizar el contenido para mejorar la visibilidad
- Implementar estrategias de participación comunitaria
- Analizar el rendimiento y el impacto de tu presencia digital

## Soporte y Contribución

- **Documentación**: [Visita nuestro wiki](https://github.com/ejemplo/wordpress-ong/wiki)
- **Problemas**: Reporta bugs en [el rastreador de problemas](https://github.com/ejemplo/wordpress-ong/issues)
- **Contribuciones**: Lee nuestra [guía de contribución](CONTRIBUTING.md) para participar en el desarrollo

## Licencia

Este proyecto se distribuye bajo la licencia GPL v3, igual que WordPress. Consulta el archivo [LICENSE](LICENSE) para más detalles.

---

¿Tienes preguntas o necesitas asistencia personalizada? Contáctanos en ayuda@wordpress-ong.org o únete a nuestro [canal de Slack](https://slack.wordpress-ong.org).# WordPress Optimizado para ONGs

[![WordPress](https://img.shields.io/badge/WordPress-6.5%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-purple.svg)](https://www.php.net/)
[![MariaDB](https://img.shields.io/badge/MariaDB-10.6%2B-orange.svg)](https://mariadb.org/)
[![Astra](https://img.shields.io/badge/Astra-4.6.10%2B-green.svg)](https://wpastra.com/)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

## Introducción

Este proyecto proporciona una solución WordPress optimizada específicamente para las necesidades de Organizaciones No Gubernamentales (ONGs). Combina la potencia y flexibilidad de WordPress con personalizaciones técnicas avanzadas y mejores prácticas orientadas a maximizar el impacto de la presencia digital de organizaciones sin fines de lucro.

## Contenidos

1. [Especificaciones Técnicas Base](#especificaciones-técnicas-base)
2. [Arquitectura WordPress Optimizada](#arquitectura-wordpress-optimizada-para-ongs)
3. [Implementación de Tema Astra](#implementación-de-tema-astra)
4. [Implementación con Elementor Pro](#implementación-técnica-con-elementor-pro)
5. [Plugins Esenciales y Configuración](#plugins-esenciales-y-configuración)
6. [Optimización SEO y Rendimiento](#optimización-seo-y-rendimiento)
7. [Seguridad y Cumplimiento](#seguridad-y-cumplimiento)
8. [Integración y Automatización](#integración-y-automatización)
9. [Estructura de Repositorio](#estructura-de-repositorio)
10. [Documentación y Consideraciones Finales](#documentación-técnica)

## Especificaciones Técnicas Base

### Stack Tecnológico Recomendado

- WordPress 6.5+
- PHP 8.1+ (configurado con límites de memoria optimizados)
- MySQL 8.0+ / MariaDB 10.6+
- Nginx (preferido) o Apache con módulos de caché
- Certificados SSL Let's Encrypt con renovación automática

## Arquitectura WordPress Optimizada para ONGs

### Configuración Core y Estructura

#### Instalación Profesional

- Configuración de dominios con DNS optimizado (TTL apropiado)
- Implementación de alojamiento especializado: Kinsta o SiteGround (planes para ONGs)
- Estructura de directorios segurizada `/home/[usuario]/public_html/` con permisos 755/644
- Implementación del modelo de seguridad por capas con `.htaccess` reforzado

#### Sistema de Archivos y Base de Datos

```php
// Configuración wp-config.php optimizada
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');
define('AUTOSAVE_INTERVAL', 300); // 5 minutos para evitar sobrecarga
define('WP_POST_REVISIONS', 10);
define('DISALLOW_FILE_EDIT', true);
```

## Implementación de Tema Astra

Astra v4.6.10+ es ideal para ONGs por su velocidad y flexibilidad:

### Creación obligatoria de child theme para personalizaciones

```php
/*
 Theme Name: Astra Child - [Nombre ONG]
 Theme URI: https://wpastra.com/
 Description: Child Theme personalizado para [Nombre ONG]
 Author: [Tu nombre]
 Author URI: [Tu sitio]
 Template: astra
 Version: 1.0.0
*/

// Enqueue parent and child styles correctly
function child_enqueue_styles() {
    wp_enqueue_style('astra-theme-css', get_template_directory_uri() . '/style.css', array(), ASTRA_THEME_VERSION, 'all');
    wp_enqueue_style('astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);

// Hooks personalizados para ONGs
function ong_custom_hooks() {
    // Funcionalidad específica para transparencia y donaciones
}
add_action('after_setup_theme', 'ong_custom_hooks');
```

## Implementación Técnica con Elementor Pro

### Construcción de Templates Clave

#### Header Optimizado para Conversión

- Estructura HTML5 semántica con landmarks ARIA
- Menú principal con acceso rápido a donaciones (clase CSS `.donation-highlight`)
- Implementación de sticky header con reducción de altura en scroll
- Botón CTA principal con tracking de eventos GA4

#### Templates de Página Especializados

1. **Homepage (impact-driven):**
   - Hero section con video de impacto (carga diferida)
   - Contador de beneficiarios/impacto con JSON-LD
   - Sección de urgencia/campaña actual

2. **Página Donar:**
   - Formulario multipaso optimizado para conversión
   - Opciones recurrentes destacadas
   - Integraciones de pasarelas múltiples (Stripe/PayPal)

3. **Template Proyectos:**
   - Estructura de taxonomías personalizadas
   - Portfolio visual con filtros AJAX
   - Datos estructurados Schema.org para proyectos benéficos

### Optimización Elementor

```php
// functions.php - Optimizaciones Elementor para ONGs
function elementor_ong_optimization() {
    // Registrar posiciones de widget personalizadas
    register_sidebar(array(
        'name' => 'Área Donación Emergencia',
        'id' => 'emergency-donation',
        'description' => 'Área para campañas urgentes o donaciones destacadas',
        'before_widget' => '<div class="emergency-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="emergency-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'elementor_ong_optimization');

// Optimización de carga Elementor
function dequeue_elementor_unnecessary() {
    // Desactivar iconos y fuentes innecesarias
    wp_dequeue_style('elementor-icons-fa-solid');
    wp_dequeue_style('elementor-icons-fa-brands');
}
add_action('elementor/frontend/after_enqueue_styles', 'dequeue_elementor_unnecessary');
```

## Plugins Esenciales y Configuración

### Core Plugins y Configuración

1. **GiveWP (Donaciones)**
   - Implementación con pago recurrente activado
   - Página de agradecimiento personalizada con seguimiento de conversión
   - Generación automática de certificados fiscales

2. **Yoast SEO**
   - Schema.org específico para NonProfit Organization
   - Plantillas de título/meta optimizadas por tipo de contenido
   - Integración con Google Search Console y verificación de propiedad

3. **Wordfence Security**
   - Reglas de firewall personalizadas
   - Bloqueo de países de alta actividad maliciosa
   - Escaneos automatizados semanales

4. **UpdraftPlus**
   - Backups incrementales diarios a almacenamiento externo
   - Retención de 30 días para archivos/base de datos
   - Restauración rápida en caso de emergencia

### Configuraciones Críticas

```php
// Seguridad mejorada para transacciones
add_filter('https_ssl_verify', '__return_true');
add_filter('https_local_ssl_verify', '__return_true');

// Optimización de sesiones para donantes recurrentes
function donor_session_optimization() {
    // Iniciar sesiones seguras para donantes
    if (!session_id() && isset($_COOKIE['give_donor'])) {
        session_start([
            'cookie_lifetime' => 86400,
            'cookie_secure' => true,
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax'
        ]);
    }
}
add_action('init', 'donor_session_optimization');
```

## Optimización SEO y Rendimiento

### Estrategia SEO para ONGs

#### Estructura de URLs y Contenido

- URLs semánticas por temática/causa: `/proyectos/educacion/alfabetizacion-rural/`
- Implementación de taxonomías personalizadas por área geográfica y ODS
- Breadcrumbs con markup Schema.org

#### Schema.org para ONGs

```json
{
  "@context": "https://schema.org",
  "@type": "NGO",
  "name": "Nombre ONG",
  "url": "https://ong-ejemplo.org",
  "logo": "https://ong-ejemplo.org/logo.png",
  "sameAs": [
    "https://www.facebook.com/ong-ejemplo",
    "https://www.twitter.com/ong-ejemplo"
  ],
  "nonprofitStatus": "Registered 501(c)(3)",
  "taxID": "12-3456789",
  "member": {
    "@type": "OrganizationRole",
    "member": {
      "@type": "Person",
      "name": "Nombre Director"
    },
    "roleName": "Director Ejecutivo"
  }
}
```

### Optimización WebVitals

#### Caching Avanzado

Implementación de WP Rocket configurado para ONGs:
- Preloader para páginas clave (donación, contacto)
- Lazy-loading de imágenes excepto hero section
- Aplazamiento de JavaScript de terceros

#### Media Optimization

```php
// Conversión automática a WebP
function webp_support_for_uploads($types) {
    $types['image/webp'] = 'webp';
    return $types;
}
add_filter('upload_mimes', 'webp_support_for_uploads');

// Tamaños personalizados para proyectos
function ong_project_image_sizes() {
    add_image_size('project-thumbnail', 480, 360, true);
    add_image_size('impact-story', 800, 450, true);
    add_image_size('donor-testimonial', 320, 320, true);
}
add_action('after_setup_theme', 'ong_project_image_sizes');
```

## Seguridad y Cumplimiento

### Protección de Datos de Donantes

#### Implementación RGPD/GDPR

- Consentimiento explícito en formularios con triple opt-in
- Registro de consentimiento en base de datos con timestamp e IP
- Procedimiento automatizado para solicitudes de eliminación

#### Hardening .htaccess

```apache
# Protección contra ataques XSS
<IfModule mod_headers.c>
  Header set X-XSS-Protection "1; mode=block"
  Header set X-Content-Type-Options "nosniff"
  Header set X-Frame-Options "SAMEORIGIN"
  Header set Content-Security-Policy "default-src 'self'; script-src 'self' https://www.google-analytics.com https://www.paypal.com 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https://www.paypal.com https://www.google-analytics.com; connect-src 'self' https://www.google-analytics.com; font-src 'self'; frame-src https://www.youtube.com https://www.paypal.com; object-src 'none'"
</IfModule>

# Proteger archivos críticos
<FilesMatch "^(wp-config\.php|\.htaccess|php\.ini|\.[hH][tT][aApP]|readme\.html|license\.txt)">
  <IfModule mod_authz_core.c>
    Require all denied
  </IfModule>
  <IfModule !mod_authz_core.c>
    Order allow,deny
    Deny from all
  </IfModule>
</FilesMatch>
```

## Integración y Automatización

### Integración con Pasarelas de Donación

```php
// Hook para acciones post-donación
function ong_after_donation_processing($donation_id, $payment_data) {
    // Añadir donante a CRM
    if (function_exists('api_crm_add_contact')) {
        $donor = new Give_Donor($payment_data['user_info']['id']);
        $tags = ['donante-web', date('Y')];
        
        // Si es donación recurrente, añadir tag especial
        if (!empty($payment_data['recurring'])) {
            $tags[] = 'donante-recurrente';
        }
        
        api_crm_add_contact([
            'email' => $donor->email,
            'name' => $donor->name,
            'phone' => $payment_data['user_info']['phone'],
            'tags' => $tags,
            'donation_amount' => $payment_data['price'],
            'donation_date' => date('Y-m-d H:i:s')
        ]);
    }
    
    // Enviar notificación interna
    wp_mail(
        get_option('admin_email'),
        'Nueva donación recibida: #' . $donation_id,
        'Se ha recibido una nueva donación por valor de ' . $payment_data['price'] . get_option('give_currency')
    );
}
add_action('give_complete_donation', 'ong_after_donation_processing', 10, 2);
```

### Automatización de Contenido de Impacto

- Implementación de Custom Post Types para proyectos e historias
- ACF Pro para campos de impacto cuantificables (beneficiarios, fondos, etc.)
- Generación automática de informes de impacto con shortcode personalizado

## Estructura de Repositorio

```
/home/daniel/programming/portafolio_web_ongs/
├── wp-content/
│   ├── themes/
│   │   ├── astra-child/
│   │   │   ├── assets/
│   │   │   │   ├── css/
│   │   │   │   │   ├── main.css
│   │   │   │   │   └── custom-elementor.css
│   │   │   │   ├── js/
│   │   │   │   │   └── donation-form-enhancements.js
│   │   │   │   └── img/
│   │   │   ├── template-parts/
│   │   │   │   ├── header-donation.php
│   │   │   │   └── impact-counter.php
│   │   │   ├── functions.php
│   │   │   └── style.css
│   ├── plugins/
│   │   └── ong-custom-functionality/
│   │       ├── includes/
│   │       │   ├── post-types.php
│   │       │   ├── shortcodes.php
│   │       │   └── metaboxes.php
│   │       └── ong-custom-functionality.php
│   └── elementor-templates/
│       ├── homepage-impact.json
│       ├── donation-page.json
│       └── project-archive.json
├── wp-config.php (optimizado)
├── .gitignore
└── README.md (documentación)
```

## Documentación Técnica

La documentación completa incluye:

- Manual de implementación paso a paso (Markdown)
- Guías de mantenimiento y actualización
- Política de respaldos y recuperación ante desastres
- Referencias API para integraciones personalizadas

## Consideraciones Finales para ONGs

### Sostenibilidad Técnica

La solución implementada está diseñada para:

- Reducir la dependencia técnica a largo plazo
- Facilitar la administración por personal no técnico
- Minimizar costos de mantenimiento
- Garantizar actualizaciones seguras y eficientes

### Evaluación de Impacto Digital

El proyecto incluye métricas clave para medir el éxito:

- Tasa de conversión de donaciones
- Tiempo de permanencia en páginas clave
- Participación en llamados a la acción
- Retorno de inversión de estrategias digitales

## Instalación

1. Descarga la última versión desde la [página de lanzamientos](https://github.com/ejemplo/wordpress-ong/releases)
2. Descomprime el archivo en tu servidor web
3. Crea una base de datos MySQL para tu instalación
4. Visita la URL del sitio en tu navegador y sigue el asistente de instalación
5. Durante la configuración, selecciona el perfil "ONG" para activar las optimizaciones específicas

## Soporte y Contribución

- **Documentación**: [Visita nuestro wiki](https://github.com/ejemplo/wordpress-ong/wiki)
- **Problemas**: Reporta bugs en [el rastreador de problemas](https://github.com/ejemplo/wordpress-ong/issues)
- **Contribuciones**: Lee nuestra [guía de contribución](CONTRIBUTING.md) para participar en el desarrollo

Para soporte técnico, contacta con [ayuda@wordpress-ong.org](mailto:ayuda@wordpress-ong.org) o abre un issue en este repositorio.

## Licencia

Este proyecto se distribuye bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
