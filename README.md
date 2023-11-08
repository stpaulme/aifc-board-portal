# AIFC Board Portal

## Installation

1. Clone this repo to `<your-project>/wp-content/themes`.
2. Navigate to the theme folder and run the following commands:
```
npm install
gulp build
```
3. Open the WordPress dashboard and activate the theme.

### Dependencies

- [WordPress](https://wordpress.org/)
- [Node](https://nodejs.org/en/)
- [Advanced Custom Fields Pro](https://advancedcustomfields.com/)
- [Timber](https://www.upstatement.com/timber/)

---

## Usage

After activating the theme in your local environment, navigate to `<your-project>/wp-content/themes/<theme-folder>` and run `gulp`. All files in `./src` will now be watched for changes and compiled to the `./dist` folder.

### Assets

The `./src` folder contains all images, JavaScript and SCSS for the theme. Files inside this folder are watched for changes and compiled to `./dist`.

### Lib

The `./lib` folder contains theme logic such as menus, custom post types and custom taxonomies that are then required in `functions.php`.

### Custom Fields

The theme uses [Advanced Custom Fields](https://advancedcustomfields.com/) for all custom fields.

In your local environment, use the ACF UI to modify custom fields. They will be automatically saved as `.json` files in the `./acf-json` folder, which allows them to be version controlled and synced to the server.

**Important: Do not use the ACF UI on the staging or the production server.** Otherwise, the `./acf-json` folder will get out of sync.

### Templates

The theme uses [Timber](https://www.upstatement.com/timber/) to separate logic (PHP files) from presentation (Twig files). The top-level PHP files in the theme folder are your typical WordPress theme files. They contain logic that supplies the Twig files in the `./templates` folder with data. All HTML is done in Twig.

---

## Deployment

GitHub Actions provides push-to-deploy functionality. During development, if you push to the `develop` branch, the theme will be compiled and synced with the staging server. After launch, if you merge a pull request into `master`, the theme will be compiled and synced with the production server.

Update server details in the `./.github` directory.

Update the `DEPLOY_KEY` on GitHub under Settings &#8594; Secrets.

### Cache busting

The theme's stylesheet is versioned using the file's last modified time. This number is added to the URL as a query string to bust caches.