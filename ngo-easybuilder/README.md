# NGO EasyBuilder - WordPress Plugin for NGOs

## Overview

NGO EasyBuilder is a WordPress plugin specifically designed for non-governmental organizations (NGOs) that require an easy and effective solution to create and manage websites. This plugin offers specialized tools tailored to the unique needs of the non-profit sector, enabling organizations to establish a professional digital presence without requiring extensive technical expertise.

---

## Key Features

### Specialized Templates for NGOs
- Predefined designs for donation pages
- Templates for showcasing projects and causes
- Optimized formats for highlighting social impact stories
- Design options adaptable to various types of organizations

### Integrated Donation System
- Secure payment processing
- Options for both recurring and one-time donations
- Automatic issuance of receipts and thank-you messages
- Fundraising campaign tracking and reporting

### Volunteer Management
- Customizable forms for volunteer registration
- Event and activity calendars
- Team coordination system
- Tools to track volunteer hours and contributions

### Transparency and Accountability
- Visualization of financial data
- Automatic impact reporting
- Simplified publication of annual reports
- Dashboards to share results with donors

---

## Benefits

- **Ease of Use**: Intuitive interface designed for non-technical users.
- **Resource Efficiency**: Eliminates the need to hire specialized web developers.
- **Regulatory Compliance**: Meets legal requirements for non-profit organizations.
- **SEO Optimization**: Enhances the organization's online visibility.
- **Responsive Design**: Works seamlessly on mobile devices and tablets.

---

## Technical Requirements

- **WordPress Version**: 6.0 or higher
- **PHP Version**: 7.4 or higher
- **Required Plugins**: Elementor (Free or Pro version)
- **Permalinks**: Must be set to a structure other than default
- **Storage**: Adequate for content volume

---

## Installation and Setup

### Installation via WordPress Dashboard
1. Download the plugin ZIP file from the [official GitHub repository](https://github.com/fdaniel-alvarez-dev/portafolio_web_ongs).
2. Navigate to `Plugins > Add New > Upload Plugin` in the WordPress admin panel.
3. Select the downloaded ZIP file and click **Install Now**.
4. Activate the plugin from the installed plugins section.

### Installation via FTP
1. Connect to your server using an FTP client and navigate to the `/wp-content/plugins/` directory.
2. Clone the repository:
   ```
   git clone https://github.com/fdaniel-alvarez-dev/portafolio_web_ongs.git
   ```
3. Navigate to the plugin directory:
   ```
   cd portafolio_web_ongs/ngo-easybuilder/
   ```
4. Activate the plugin from the WordPress admin panel.

---

## Plugin Usage

### Initial Configuration
1. After activation, navigate to **NGO EasyBuilder** in the main WordPress menu.
2. Fill in your organization's information on the settings page.
3. Configure payment integrations under the **Donations** tab.
4. Customize email settings for notifications.

### Donation System
- The donation module is implemented in the file:
  ```
  class-donation-system.php
  ```
  Features include:
  - Embed donation forms on any page.
  - An admin panel for reviewing donations.
  - Automatic generation of tax receipts.
  - Donation pattern analysis.

- Example shortcode for embedding a donation form:
  ```
  [ngo_donation_form amount="50,100,200" recurring="true" campaign="clean-water"]
  ```

### Volunteer Management
- The volunteer management system is implemented in:
  ```
  class-volunteer-manager.php
  ```
  Features include:
  - Create volunteer profiles with skills and interests.
  - Schedule events and assign volunteers.
  - Track hours and generate certificates.
  - Group communication by project.

---

## Advanced Customization

For developers looking to extend functionality, the file:
```
Advanced_Customization_Custom_Post_Types_Projects
```
provides documentation on:
- Creating additional custom fields.
- Modifying taxonomies.
- Integration with external APIs.
- Hooks and filters for customization.

---

## Example Campaign Setup

The file:
```
Example_Creating_Campaign_Showcase
```
provides step-by-step instructions for:
- Setting up a complete fundraising campaign.
- Defining goals and timers.
- Integrating with social media platforms.
- Adding progress bars and counters.

---

## Plugin Structure

```
ngo-easybuilder/
├── elementor/widgets/       # Custom widgets for Elementor
├── includes/                # Core functionalities of the plugin
├── Advanced_Customization_Custom_Post_Types_Projects  # Customization guide
├── Example_Creating_Campaign_Showcase  # Campaign tutorial
├── class-donation-system.php  # Donation system implementation
├── class-volunteer-manager.php  # Volunteer management implementation
├── ngo-easybuilder.php       # Main plugin file
├── README.md                 # Documentation
```

---

## Additional Documentation

For detailed information on each component:
- **Donation System**: [View Documentation](#)
- **Volunteer Management**: [View Documentation](#)
- **Elementor Widgets**: [View Documentation](#)
- **APIs and Hooks**: [View Developer Documentation](#)

---

## Contributing

We welcome contributions to enhance NGO EasyBuilder. To contribute:
1. Fork the repository.
2. Create a branch for your feature:
   ```
   git checkout -b feature/AmazingFeature
   ```
3. Commit your changes:
   ```
   git commit -m "Add some AmazingFeature"
   ```
4. Push to the branch:
   ```
   git push origin feature/AmazingFeature
   ```
5. Open a pull request.

---

## License

This project is licensed under the GNU General Public License v3.0. See the LICENSE file for more details.

---

## Support

Have questions or need assistance? Open an issue in this repository or contact our support team at [support@ngo-easybuilder.org](mailto:support@ngo-easybuilder.org).

---

## Developed for organizations making the world a better place.

Visit the [main repository](https://github.com/fdaniel-alvarez-dev/portafolio_web_ongs) for more information.
