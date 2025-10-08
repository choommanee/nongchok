# Ayam Bangkok Core Plugin

Core functionality plugin for Ayam Bangkok website - Thailand's official rooster export representative to Indonesia.

## Features

### Custom Post Types
- **Roosters (ayam_rooster)** - Fighting roosters with detailed information
- **Services (ayam_service)** - Various services offered by the company
- **News (ayam_news)** - News and announcements
- **Knowledge (ayam_knowledge)** - Educational content about rooster care

### Custom Taxonomies
- **Rooster Breeds** - Different breeds of fighting roosters
- **Rooster Categories** - Categories like "Ready for Export", "In Training", etc.
- **Service Categories** - Types of services offered
- **News Categories** - News categorization
- **Knowledge Categories** - Educational content categories

### Custom User Roles
- **Manager (ayam_manager)** - Full management capabilities
- **Staff (ayam_staff)** - Content management and customer service
- **Premium Member (premium_member)** - Special pricing and priority booking
- **Regular Member (regular_member)** - Basic member access

### Database Tables
- **Bookings** - Service booking management
- **Inquiries** - Customer inquiries and support
- **Export Records** - Rooster export tracking
- **Gallery** - Rooster image galleries
- **User Preferences** - Member preferences and settings
- **Activity Log** - System activity tracking

### REST API Endpoints
- `/wp-json/ayam/v1/roosters` - Rooster listings
- `/wp-json/ayam/v1/roosters/search` - Advanced rooster search
- `/wp-json/ayam/v1/services` - Service listings
- `/wp-json/ayam/v1/bookings` - Booking management
- `/wp-json/ayam/v1/inquiries` - Inquiry submission

### Key Functions
- `ayam_get_rooster_data($id)` - Get complete rooster information
- `ayam_search_roosters($args)` - Advanced rooster search with filters
- `ayam_format_price($price)` - Format price in Thai Baht
- `ayam_format_age($months)` - Format age in Thai format
- `ayam_create_booking($data)` - Create new service booking
- `ayam_create_inquiry($data)` - Create new customer inquiry

## Installation

1. Upload the plugin files to `/wp-content/plugins/ayam-bangkok-core/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. The plugin will automatically create necessary database tables and default data

## Requirements

- WordPress 5.0 or higher
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Advanced Custom Fields Pro (recommended)

## Configuration

### Required Plugins
- Advanced Custom Fields Pro - For custom field management
- Contact Form 7 - For contact forms
- Yoast SEO - For SEO optimization (optional)
- WPML - For multi-language support (optional)

### Theme Integration
This plugin is designed to work with the custom Ayam Bangkok theme. It provides:
- Custom post type templates
- REST API endpoints for AJAX functionality
- Frontend JavaScript and CSS assets
- Admin interface enhancements

## Usage

### Adding Roosters
1. Go to WordPress Admin > Roosters > Add New
2. Fill in rooster details including price, age, weight, breed
3. Upload images to the gallery
4. Set export readiness status
5. Publish the rooster

### Managing Bookings
1. Go to WordPress Admin > Bookings
2. View all service bookings
3. Update booking status (pending, confirmed, completed, cancelled)
4. Add admin notes and manage customer communications

### Handling Inquiries
1. Go to WordPress Admin > Inquiries
2. View customer questions and requests
3. Reply to inquiries directly from the admin panel
4. Mark inquiries as read/unread
5. Assign inquiries to staff members

### Generating Reports
1. Go to WordPress Admin > Reports
2. Select report type and date range
3. Generate analytics on roosters, bookings, and inquiries
4. Export reports in various formats

## Customization

### Adding Custom Fields
Use Advanced Custom Fields Pro to add additional fields to roosters, services, or other post types.

### Extending API
Add new REST API endpoints by extending the `AyamAPI` class in `includes/class-ayam-api.php`.

### Custom User Roles
Modify user roles and capabilities in `includes/class-ayam-user-roles.php`.

### Database Schema
Extend database tables by modifying `includes/class-ayam-database.php`.

## Security

The plugin implements several security measures:
- Nonce verification for all forms
- Input sanitization and validation
- User capability checks
- SQL injection prevention
- XSS protection

## Performance

- Database query optimization
- Caching for frequently accessed data
- Lazy loading for images
- Minified CSS and JavaScript assets

## Support

For support and customization requests, please contact the development team.

## Changelog

### Version 1.0.0
- Initial release
- Custom post types and taxonomies
- User role management
- Database schema creation
- REST API endpoints
- Admin interface
- Frontend assets

## License

This plugin is proprietary software developed specifically for Ayam Bangkok (หนองจอก เอฟซีไอ).