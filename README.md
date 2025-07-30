# Bar Manager (Back Office)

Bar Manager BO is a web-based application for bar inventory and operations management. It provides a back-office interface to manage products (inventory items like beverages and ingredients), suppliers, menu items (referred to as “sellables”), and orders, helping bar managers track stock levels and streamline inventory control. The system is built with Laravel (PHP framework) and offers features such as low-stock alerts, recipe management for drinks, and automatic stock deduction when drinks are sold. In essence, Bar Manager BO facilitates efficient bar management by combining inventory tracking with menu (recipe) management and order logging.

***

### Key Features

- **Product & Inventory Management:** Create and manage products representing inventory items (e.g. bottles, ingredients). For each product, the system tracks the available quantity in appropriate units (units, milliliters, or grams) and allows updating stock levels (adding or removing inventory) from the admin interface. Managers can set a stock alert threshold per product to receive warnings when stock is at or below that level. Low-stock products are highlighted on the dashboard so you can restock timely.

- **Category Management:** Organize menu items into categories (e.g. Cocktails, Beer, Wine) for easy filtering and navigation. You can create, edit, and delete categories via the intuitive CRUD interface. Categories help classify sellable items and improve the overview of offerings.

- **Supplier Management:** Maintain a list of suppliers for your products. Each product can be linked to a supplier, so you know where to re-order stock from. The application provides CRUD operations for suppliers (add/edit/remove) from the back-office interface.

- **Sellables (Menu Items) Management:** Define “sellables,” which are the drinks or menu items you sell (for example, a cocktail, a pizza or beer). Crucially, you can assign one or more products (ingredients) to a sellable along with the quantity of each product used in that recipe. This essentially lets you build a recipe/BOM (Bill of Materials) for each drink. The interface allows adding or removing ingredient entries for a sellable and specifying their quantities.

- **Automated Stock Deduction:** When an order is recorded, the system automatically deducts the appropriate amounts of each product used in the ordered items from the inventory. For example, if a cocktail uses 50 ml of gin and 200 ml of tonic, ordering that cocktail will reduce the gin’s stock by 50 ml and tonic’s stock by 200 ml in the system. This is handled transparently whenever an order is placed through the app’s order logging feature, ensuring your inventory levels stay up-to-date in real time.

- **Order Management:** Record and manage customer orders for sellable items. Orders are logged with their details, including which sellable items were sold (and in what quantity). The app supports creating orders through an API endpoint (for integration with a frontend). An order may have a status (e.g. pending, completed), and the admin interface provides an orders list with pagination and filtering by status to help track ongoing and past orders. Viewing an order shows its details (items and quantities), and listing orders provides an overview of sales over time.

- **Dashboard & Alerts:** Upon logging in, a dashboard gives a quick overview of the bar’s status. This includes alerts for low-stock items (products that have reached or fallen below their defined alert threshold), so managers can see at a glance what needs reordering.

- **User Authentication & Security:** The application comes with user authentication out of the box (powered by Laravel Breeze). Users can register and log in to access the admin panel, but only those with email addresses listed in the .env ALLOWED_EMAILS parameter are allowed to register. Only authenticated and verified users can access the back-office routes. A user profile section is included, allowing password updates and profile edits. Cross-Origin Resource Sharing (CORS) is also enabled/configurable, allowing safe integration of external front-end applications or POS systems with the API.

- **Responsive UI with Bootstrap:** The front-end uses Bootstrap 5 for a mobile-responsive, clean interface. Common UI components like navigation bars, forms, tables, modals, and buttons adhere to Bootstrap styling for consistency and ease of use. For instance, deletion actions use confirmation modals to prevent accidental data loss (e.g. confirming category or sellable deletion). Icons from Font Awesome are included for visual clarity (e.g. icons for edit/delete actions). The styling has been customized via SCSS, and the layout ensures the app is usable on various screen sizes.

- **Search & Filters:** To quickly find records, the app includes search and filter functionality. Sellables can be filtered by category on the index page, and there is a search-by-name field to look up sellable items by keyword. Similar search or filter features are implemented for other resources where applicable (for example, you can search products or suppliers by name in their index pages), making it easy to manage a large catalog of items.

- **Robust MVC Structure:** The project is organized following Laravel’s MVC conventions. There are dedicated Eloquent models for each main entity (Product, Category, Supplier, Sellable, Order), with relationships set up. Controllers handle the business logic and form requests, including validation for inputs. Blade templates are used for views, and are organized by resource, promoting reusability and clarity. This clean separation makes the codebase maintainable and extensible for future features.

---

### Technologies Used

- **Backend / Framework:** The project is built on Laravel 11, leveraging Laravel’s features like Eloquent ORM, migration system and form validation. Laravel Breeze is used for scaffolding authentication and basic frontend setup (Blade templates with Bootstrap).

- **Database:** It uses a SQL database via Eloquent. By default, the configuration is set to use MySQL, and you can configure the connection settings in the environment file. The schema is managed through Laravel migrations, and there are seeders available to populate initial data for categories, suppliers, products and sellables.

- **Frontend:** Uses HTML5 and Blade templating on the server side, styled with Bootstrap 5 and custom SCSS styles. Icons are provided by Font Awesome Free for a richer UI. No heavy frontend framework is required, the UI is largely server-rendered and enhanced with modest JavaScript where needed (e.g. for modal dialogs and form enhancements).

---

### Installation

1. **Prerequisites:** Ensure you have PHP 8.2+ installed, as well as Composer (for PHP dependencies) and Node.js/NPM (for building front-end assets). Make sure to have the database system running (e.g. MySQL) and obtain the connection credentials.

2. **Clone the Repository:** Clone this GitHub repository to your local development environment

   ```
   git clone https://github.com/emanuelesguerzo/bar-manager-bo.git
   cd bar-manager-bo  
   ```
   
3. **Install PHP Dependencies:** Run Composer to install Laravel and all required PHP libraries

    ```
    composer install
    ```


4. **Install Node Dependencies:** Install front-end build dependencies using NPM (this will pull in Bootstrap, Vite, etc., as defined in package.json)

    ```
    npm install
    ```

5. **Environment Configuration:** Copy the example environment file and adjust settings as needed
    
    ```
    cp .env.example .env
    ```

6. **Generate Application Key:** Laravel requires a unique application key for encryption. Generate this by running

    ```
    php artisan key:generate
    ```

7. **Run Migrations:** Set up the database tables by running Laravel migrations

    ```
    php artisan migrate
    ```

8. **(Optional) Seed Initial Data:** You can seed the database with some sample data for categories, suppliers, and sellables

    ```
    php artisan db:seed
    ```

9. **Build Frontend Assets:** Compile the CSS and JS assets using Vite

    
    ```
    npm run build
    ```
    
---

### Running the Application

After installation, run the application:

    php artisan serve

and in another terminal:

    npm run dev

---

### License

This project is open source and available under the MIT License. Feel free to use and modify it according to the license terms.
