# Quick Start Guide - NewsToday Theme

## Initial Setup

### 1. Install Dependencies

```bash
cd wp-content/themes/newstoday
npm install
```

This will install:
- Vite (build tool)
- Sass (SCSS compiler)
- @vitejs/plugin-legacy (browser compatibility)
- vite-plugin-image-optimizer (image optimization)

### 2. Development Workflow

**Start the development server:**

```bash
npm run dev
```

This will:
- Start Vite dev server on `http://localhost:5173`
- Enable Hot Module Replacement (HMR)
- Watch for file changes in `assets/src/`
- Serve assets directly from dev server

**Important:** Make sure `WP_DEBUG` is set to `true` in your `wp-config.php` for development mode to work.

### 3. Build for Production

When ready to deploy:

```bash
npm run build
```

This will:
- Compile and minify SCSS → CSS
- Bundle and minify JavaScript
- Optimize images
- Generate hashed filenames for cache busting
- Create a manifest.json for asset loading
- Output everything to `assets/dist/`

### 4. Activate the Theme

1. Go to WordPress Admin → Appearance → Themes
2. Activate "NewsToday"

## File Structure at a Glance

```
newstoday/
├── assets/
│   ├── src/              ← Edit these files
│   │   ├── scss/         ← Your styles
│   │   ├── js/           ← Your scripts
│   │   └── images/       ← Source images
│   └── dist/             ← Generated files (don't edit)
├── inc/                  ← PHP functions
├── template-parts/       ← Reusable templates
├── functions.php         ← Main theme file
├── style.css            ← Theme header (required)
├── package.json         ← Node dependencies
└── vite.config.js       ← Build configuration
```

## Development Tips

### Working with SCSS

1. Edit files in `assets/src/scss/`
2. Main entry: `main.scss`
3. Variables: `_variables.scss`
4. Changes auto-reload with HMR

### Working with JavaScript

1. Edit files in `assets/src/js/`
2. Main entry: `main.js`
3. Import modules as needed
4. Changes auto-reload with HMR

### Adding Images

1. Place images in `assets/src/images/`
2. Reference in CSS: `url('../images/your-image.jpg')`
3. Images are automatically optimized on build

## Common Tasks

### Add a new template file

Create PHP file in root or `template-parts/` directory

### Add a new widget area

Edit `inc/widgets.php`

### Add a custom post type

Edit `inc/custom-post-types.php`

### Modify theme setup

Edit `inc/theme-setup.php`

### Change asset loading

Edit `inc/enqueue-assets.php`

## Troubleshooting

**Assets not loading in development?**
- Make sure `npm run dev` is running
- Check that Vite dev server is on `http://localhost:5173`
- Verify `WP_DEBUG` is `true` in `wp-config.php`

**Assets not loading in production?**
- Run `npm run build` first
- Check that `assets/dist/` contains files
- Verify `manifest.json` exists in `assets/dist/`

**Styles not updating?**
- Hard refresh browser (Cmd+Shift+R or Ctrl+Shift+R)
- Clear WordPress cache if using caching plugin
- Make sure you're editing files in `src/` not `dist/`

## Next Steps

1. ✅ Install dependencies: `npm install`
2. ✅ Start dev server: `npm run dev`
3. ✅ Activate theme in WordPress
4. Start customizing SCSS and JS files
5. Add your own templates and components
6. Build for production when ready

---

For more details, see the full README.md file.

