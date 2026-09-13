# NewsToday WordPress Theme

A modern WordPress theme built with Vite, SCSS, and best practices.

## Features

- ⚡ **Vite** for lightning-fast development and optimized production builds
- 🎨 **SCSS** for organized and maintainable styles
- 📱 **Responsive** design with mobile-first approach
- ♿ **Accessible** markup following WordPress standards
- 🚀 **Optimized** assets with automatic minification and compression
- 🖼️ **Image optimization** built into the build process
- 🔧 **Modern JavaScript** with ES6+ support

## Development

### Prerequisites

- Node.js (v18 or higher)
- npm or yarn
- WordPress installation

### Installation

1. Install dependencies:
```bash
npm install
```

2. Start development server:
```bash
npm run dev
```

The development server will run at `http://localhost:5173`

### Development Mode

In development mode, Vite serves assets from its dev server with hot module replacement (HMR). The theme automatically detects if Vite is running and loads assets from the dev server.

Make sure to:
1. Run `npm run dev` before developing
2. Keep the Vite server running while developing
3. Set `WP_DEBUG` to `true` in your `wp-config.php`

## Production Build

To build for production:

```bash
npm run build
```

This will:
- Compile and minify SCSS to CSS
- Bundle and minify JavaScript
- Optimize images
- Generate a manifest file for asset loading
- Output everything to `assets/dist/`

## Project Structure

```
newstoday/
├── assets/
│   ├── src/
│   │   ├── scss/          # SCSS source files
│   │   ├── js/            # JavaScript source files
│   │   └── images/        # Source images
│   └── dist/              # Build output (generated)
├── inc/
│   ├── theme-setup.php    # Theme setup and configuration
│   ├── enqueue-assets.php # Asset loading with Vite support
│   ├── custom-post-types.php
│   ├── widgets.php
│   └── template-functions.php
├── template-parts/        # Reusable template parts
│   ├── header/
│   ├── footer/
│   ├── content/
│   └── navigation/
├── languages/             # Translation files
├── functions.php          # Main theme functions
├── style.css             # Theme header (required by WordPress)
├── package.json          # Node dependencies
├── vite.config.js        # Vite configuration
└── .gitignore

```

## Theme Structure

### Core Files

- `functions.php` - Main theme functions and setup
- `style.css` - Theme header information (required)
- `index.php` - Main template fallback

### Template Files

- `header.php` - Site header
- `footer.php` - Site footer
- `sidebar.php` - Sidebar widget area
- `single.php` - Single post template
- `page.php` - Page template
- `archive.php` - Archive template
- `search.php` - Search results template
- `404.php` - 404 error page
- `comments.php` - Comments template

### inc/ Directory

Organized functions loaded from `functions.php`:

- `theme-setup.php` - Theme features and support
- `enqueue-assets.php` - Scripts and styles with Vite integration
- `custom-post-types.php` - Custom post types and taxonomies
- `widgets.php` - Widget areas registration
- `template-functions.php` - Template helper functions

### Assets Structure

#### SCSS (`assets/src/scss/`)
- `main.scss` - Main entry point
- `_variables.scss` - SCSS variables (colors, fonts, spacing)
- `_mixins.scss` - Reusable mixins
- `_base.scss` - Base styles and resets
- `_typography.scss` - Typography styles
- `_layout.scss` - Layout structures
- `_components.scss` - UI components
- `_utilities.scss` - Utility classes

#### JavaScript (`assets/src/js/`)
- `main.js` - Main entry point
- `navigation.js` - Navigation functionality
- `utils.js` - Utility functions

## Vite Integration

### How It Works

1. **Development Mode**: When `WP_DEBUG` is true and Vite is running, the theme loads assets from the Vite dev server (`http://localhost:5173`)

2. **Production Mode**: In production, the theme loads compiled assets from `assets/dist/` using the manifest file

### Asset Loading

The `enqueue-assets.php` file handles:
- Detection of development vs production mode
- Loading Vite client and HMR in development
- Reading and parsing the manifest in production
- Proper script/style enqueuing with WordPress functions

## Customization

### Adding New SCSS Files

1. Create a new SCSS file in `assets/src/scss/`
2. Import it in `main.scss`:
```scss
@import 'your-new-file';
```

### Adding New JavaScript Modules

1. Create a new JS file in `assets/src/js/`
2. Import it in `main.js`:
```javascript
import { yourFunction } from './your-new-file.js';
```

### Adding Images

Place images in `assets/src/images/` and they will be automatically optimized during build.

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE 11+ with legacy plugin
- Mobile browsers

## License

This theme is licensed under the GPL v2 or later.

## Credits

Built with:
- [Vite](https://vitejs.dev/)
- [Sass](https://sass-lang.com/)
- [WordPress](https://wordpress.org/)

