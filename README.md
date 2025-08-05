
# Bar Manager Backend 🧾🛠️📦

Bar Manager BO is a web-based application for managing bar inventory and operations. It allows staff to manage products (like beverages and ingredients), suppliers, menu items (referred to as “sellables”), and orders from an admin panel.

This backend is designed to work in tandem with the companion frontend project [bar-manager-fo](https://github.com/emanuelesguerzo/bar-manager-fo), which acts as the customer-facing digital menu. 

Orders placed through the frontend are received and processed here, with automatic stock deduction based on the defined ingredients.

## Overview

Bar Manager Backend provides the server-side logic and data management for the Bar Manager platform. It handles inventory tracking, recipe logic, order processing, and API communication with the frontend.

Sellable items (like cocktails or dishes) are linked to real inventory products via recipes, allowing the system to automatically deduct the correct stock quantities when an order is placed.

The backend exposes RESTful API endpoints that the [Bar Manager Frontend](https://github.com/emanuelesguerzo/bar-manager-fo) consumes to fetch data and submit orders. Together, these two parts form a complete full-stack system for modern bar operations.

---

### Key Features

1. **Product & Inventory Management:**
    - Create and manage products representing inventory items (e.g. bottles, ingredients).
    - For each product, the system tracks the available quantity in appropriate units (units, milliliters, or grams) and allows updating stock levels (adding or removing inventory) from the admin interface.
    - Managers can set a stock alert threshold per product to receive warnings when stock is at or below that level.
    - Low-stock products are highlighted on the dashboard so you can restock timely.

2. **Category Management:**
    - Organize menu items into categories (e.g. Cocktails, Beer, Wine) for easy filtering and navigation.
    - You can create, edit, and delete categories via the intuitive CRUD interface.
    - Categories help classify sellable items and improve the overview of offerings.

3. **Supplier Management:**
    - Maintain a list of suppliers for your products.
    - Each product can be linked to a supplier, so you know where to re-order stock from.
    - The application provides CRUD operations for suppliers (add/edit/remove) from the back-office interface.

4. **Sellables (Menu Items) Management:**
   - Define “sellables,” which are the drinks or menu items you sell (for example, a cocktail, a pizza or beer).
   - Crucially, you can assign one or more products (ingredients) to a sellable along with the quantity of each product used in that recipe. This essentially lets you build a recipe/BOM (Bill of Materials) for each drink.
   - The interface allows adding or removing ingredient entries for a sellable and specifying their quantities.

5. **Automated Stock Deduction:**
   - When an order is recorded, the system automatically deducts the appropriate amounts of each product used in the ordered items from the inventory.
   - For example, ordering a cocktail that uses 50 ml of gin and 200 ml of tonic will automatically reduce the stock of gin and tonic by those exact amounts.
   - This is handled transparently whenever an order is placed through the app’s order logging feature, ensuring your inventory levels stay up-to-date in real time.

6. **Order Management:**
   - Record and manage customer orders for sellable items.
   - Orders are logged with their details, including which sellable items were sold (and in what quantity).
   - The app supports creating orders through an API endpoint (for integration with a frontend).
   - Each order has a status (sent, preparing, served, closed), and the admin panel includes pagination and filtering options to track and manage orders effectively.
   - Viewing an order shows its details (items and quantities), and listing orders provides an overview of sales over time.

7. **Dashboard & Alerts:**
   - Upon logging in, a dashboard gives a quick overview of the bar’s status.
   - This includes alerts for low-stock items (products that have reached or fallen below their defined alert threshold), so managers can see at a glance what needs reordering.

8. **Search & Filters:**
    - To quickly find records, the app includes search and filter functionality.
    - Sellables can be filtered by category on the index page, and there is a search-by-name field to look up sellable items by keyword.
    - Similar search and filter options are available for other resources (e.g. products and suppliers), making it easy to manage a large catalog.

---

### Technologies Used

1. **Laravel 11:**
   
   - The backend is built using Laravel, a modern PHP framework that provides routing, controller logic, database access via Eloquent ORM, form validation, and more.

2. **Laravel Breeze:**
   
   - Used for basic authentication scaffolding and a lightweight frontend setup with Blade, Bootstrap, and Vite integration.

3. **MySQL (via Eloquent):**
   
   - The app uses a relational SQL database.
   - Migrations define the schema, and seeders provide initial data for products, categories, suppliers, and sellables.

4. **Blade Templating:**

   - Server-side rendering is handled via Blade templates, which structure the admin panel pages and layout.

5. **Bootstrap 5:**

   - Provides responsive styling and UI components for the admin panel (e.g. tables, forms, modals).

6. **SCSS:**

   - Custom SCSS styles are used to override or extend Bootstrap's default look for a cleaner UI.

7. **Font Awesome:**

   - Icons are added using the free version of Font Awesome, improving UX and visual clarity.

8. **Vite:**

   - Vite is used to compile and serve frontend assets (CSS/JS) efficiently in both development and production modes.

---

### Getting Started

1. **Prerequisites:**
   
   - Ensure you have PHP 8.2+ installed, as well as Composer (for PHP dependencies) and Node.js/NPM (for building front-end assets).
   - Make sure to have the database system running (e.g. MySQL) and obtain the connection credentials.

2. **Clone the Repository:**
   
   - Clone this GitHub repository to your local development environment

       ```
       git clone https://github.com/emanuelesguerzo/bar-manager-bo.git
       cd bar-manager-bo  
       ```
   
3. **Install PHP Dependencies:**
   
   - Run Composer to install Laravel and all required PHP libraries

        ```
        composer install
        ```


4. **Install Node Dependencies:**
   
   - Install front-end build dependencies using NPM (this will pull in Bootstrap, Vite, etc., as defined in package.json)

        ```
        npm install
        ```

5. **Environment Configuration:**
   
   - Copy the example environment file and adjust settings as needed
    
        ```
        cp .env.example .env
        ```

6. **Generate Application Key:**
   
    - Laravel requires a unique application key for encryption. Generate this by running
    
        ```
        php artisan key:generate
        ```

7. **Run Migrations:**
   
    - Set up the database tables by running Laravel migrations

        ```
        php artisan migrate
        ```

8. **(Optional) Seed Initial Data:**

    - You can seed the database with some sample data for categories, suppliers, and sellables

        ```
        php artisan db:seed
        ```
        
---

### Running the Application

- After installation, run the application:

   - `php artisan serve`

- And in a separate terminal:

   - `npm run dev`

- Make sure both the Laravel server and the Vite dev server are running at the same time.
  
---

### Related Projects

- [Bar Manager Frontend](https://github.com/emanuelesguerzo/bar-manager-fo) - Digital menu interface connected to this backend

---

### Work in Progress

I'm still working on this project and plan to add new features, improvements, and refinements over time.

Feedback and suggestions are welcome! ❤️

---

### License

This project is open source and available under the MIT License. Feel free to use and modify it according to the license terms.
