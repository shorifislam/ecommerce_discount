# ecommerce_discount

## Overview

This project is a **Discount System API** built with **Laravel**, allowing merchants to create and apply discounts at checkout. The API supports **percentage-based** and **fixed amount** discounts, with optional constraints like minimum cart total and validity periods.

### **Features**

-   Create, manage, and apply discount codes.
-   Support for **percentage** and **fixed amount** discounts.
-   Option to set **minimum cart total** for discounts.
-   Discounts have **activation dates** and **expiration dates**.

---

## **Installation Guide**

### **Prerequisites**

Make sure you have the following installed:

-   [Composer](https://getcomposer.org/)
-   https://laravel.com/docs/12.x/installation
-   PHP 8.2 or higher
-   Laravel 12

---

### **Step 1: Clone the Repository**

```bash
  git clone https://github.com/shorifislam/ecommerce_discount.git
  cd ecommerce_discount
```

## Sqlite was used for this project. Feel free to use any SQL database.

###

```bash
  php artisan migrate:fresh
  php artisan serve
```

---

## **Discount Rule Engine**

### **How It Works**

The **Discount Rule Engine** evaluates the cart and applies a valid discount based on:

-   **Discount Type:** Percentage-based or fixed amount.
-   **Minimum Cart Total:** Ensures the cart meets the required total before applying.
-   **Validity Period:** Ensures the discount is active within the given dates.

When a discount is applied:

1. It checks **if the discount is valid** (active, not expired, and meets the minimum total requirement).
2. It **calculates the discount** based on percentage or fixed amount.
3. It **deducts the discount** from the cart total.

---

## **API Endpoints**

### **1. Create a Discount**

**Endpoint:** `POST /api/discounts`

#### **Request Body**

```json
{
    "code": "BOXINGDAY30",
    "discount_type": "percentage",
    "amount": 30,
    "min_cart_total": 100,
    "is_active": true,
    "active_from": "2025-03-01",
    "active_to": "2025-03-31"
}
```

#### **Response**

```json
{
    "message": "Discount was created successfully!",
    "data": {
        "code": "BOXINGDAY30",
        "discount_type": "percentage",
        "amount": 30,
        "min_cart_total": 100,
        "is_active": true,
        "active_from": "2025-03-01T00:00:00.000000Z",
        "active_to": "2025-03-31T00:00:00.000000Z"
    },
    "status": true
}
```

### **2. Apply a Discount**

**Endpoint:** `POST /api/apply-discount`

#### **Request Body**

```json
{
    "code": "BOXINGDAY20",
    "subtotal": 200
}
```

#### **Response**

```json
{
    "message": "Discount is not yet active.",
    "data": {
        "total": 200,
        "discount": 0
    },
    "status": false
}
```

---

## **Test Cases for API Endpoints**

### **1. Creating a Discount (Valid Request)**

#### **Input:**

```json
{
    "code": "LABOURDAY20",
    "discount_type": "money",
    "amount": 20,
    "min_cart_total": 100,
    "is_active": true,
    "active_from": "2025-02-25",
    "active_to": "2025-02-28"
}
```

#### **Expected Output:**

-   Status: `201 Created`
-   Response:

```json
{
    "message": "Discount was created successfully!",
    "discount": { ... }
}
```

### **2. Applying a Discount (Valid Code & Meets Requirements)**

#### **Input:**

```json
{
    "code": "LABOURDAY20",
    "subtotal": 200
}
```

#### **Expected Output:**

-   Status: `200 OK`
-   Response:

```json
{
    "message": "Discount applied.",
    "data": {
        "total": 180,
        "discount": 20
    },
    "status": true
}
```

### **3. Applying an Expired Discount**

#### **Input:**

```json
{
    "code": "CHRISTMAS24",
    "subtotal": 200
}
```

#### **Expected Output:**

-   Response:

```json
{
    "message": "Discount has expired.",
    "data": {
        "total": 200,
        "discount": 0
    },
    "status": false
}
```

## **Code Structure**

-   **`app/Http/Controllers/DiscountController.php`** → Handles API requests for discounts.
-   **`app/Services/DiscountService.php`** → Contains business logic for applying discounts.
-   **`app/Models/Discount.php`** → Represents discount records.
-   **`app/Http/Requests/StoreDiscountRequest.php`** → Validates incoming discount creation requests.
-   **`app/traits/ApiResponse.php`** →. API Respose trait.
-   **`database/migrations`** → Contains migration files for setting up database tables.

---

A minimal discount rule engine allows merchants to create and apply discounts at checkout based on predefined rules. The system should support two types of discounts: percentage-based (e.g., 20% off) and fixed amount (e.g., $10 off). Each discount rule should be stored in the database with optional constraints such as minimum cart total, validity period, and active status. The discount rules should be applied dynamically during checkout, ensuring they meet the criteria before reducing the total price.

The engine should evaluate the cart total against the defined rules to determine eligibility. If the cart meets the discount’s conditions (e.g., total amount exceeds a minimum threshold), the discount should be applied. Handling multiple discounts can be an additional feature—either allowing them to stack (e.g., applying multiple valid discounts) or enforcing only one discount per order. Currently, the system supports only one discount per cart, meaning the user must enter a valid discount code manually at checkout.
