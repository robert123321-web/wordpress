# Dynamic Creative Code Gallery - WordPress Theme

A modern, advanced WordPress theme for showcasing creative code projects with dynamic filtering, AJAX loading, and beautiful UI.

## Features

- **Custom Post Type**: Code Projects with custom fields
- **Custom Taxonomies**: Project Categories and Languages
- **AJAX Filtering**: Real-time project filtering without page reload
- **Modal Lightbox**: View project details in an elegant modal
- **Syntax Highlighting**: Beautiful code display
- **Responsive Design**: Mobile-first approach
- **Advanced PHP**: Custom meta boxes, AJAX handlers, and WordPress best practices
- **Modern UI**: Dark theme with gradient accents and smooth animations

## Installation

1. **Download the theme** and extract the folder
2. **Upload to WordPress**:
   - Copy the entire `dynamic-code-gallery` folder to `/wp-content/themes/`
   - Or zip the folder and upload via WordPress Admin > Appearance > Themes > Add New
3. **Activate the theme** from Appearance > Themes
4. **Create a menu** at Appearance > Menus and assign it to "Primary Menu"

## Usage

### Adding Code Projects

1. Go to **Code Gallery > Add New Project** in WordPress admin
2. Fill in the project details:
   - **Title**: Project name
   - **Content**: Full project description
   - **Featured Image**: Project thumbnail
   - **Code Snippet**: Paste your code
   - **Demo URL**: Link to live demo (optional)
   - **GitHub URL**: Link to repository (optional)
   - **Difficulty**: Select beginner/intermediate/advanced
3. Assign **Categories** and **Languages**
4. Click **Publish**

### Managing Categories

- Go to **Code Gallery > Categories** to add project categories
- Examples: "Animation", "Data Visualization", "Interactive", "Games"

### Managing Languages

- Go to **Code Gallery > Languages** to add programming languages
- Examples: "JavaScript", "CSS", "HTML", "PHP", "Canvas"

## File Structure

\`\`\`
dynamic-code-gallery/
├── style.css              # Main stylesheet with theme header
├── functions.php          # Theme functions and custom post types
├── index.php             # Main template (homepage)
├── header.php            # Header template
├── footer.php            # Footer template
├── single-code_project.php   # Single project template
├── archive-code_project.php  # Archive template
├── template-parts/
│   └── gallery-item.php  # Gallery item partial
├── js/
│   └── main.js          # JavaScript for AJAX and interactions
└── README.md            # This file
\`\`\`

## Customization

### Colors

Edit the CSS variables in `style.css`:

\`\`\`css
:root {
  --primary-color: #6366f1;
  --secondary-color: #8b5cf6;
  --accent-color: #ec4899;
  /* ... more colors */
}
\`\`\`

### Fonts

The theme uses Inter from Google Fonts. To change fonts, edit the Google Fonts URL in `functions.php`:

\`\`\`php
wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=YourFont:wght@400;700&display=swap');
\`\`\`

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- jQuery (included with WordPress)

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Credits

- Built with WordPress best practices
- Uses modern CSS Grid and Flexbox
- AJAX powered by WordPress REST API
- Icons: Unicode symbols

## License

GPL v2 or later

## Support

For issues or questions, please refer to WordPress documentation or community forums.

---

**Enjoy building your creative code gallery!** 🚀
