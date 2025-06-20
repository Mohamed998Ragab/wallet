# API Documentation

This document details the RESTful API endpoints for the Wallet System, built with Laravel Sanctum for authentication.

## Base URL

`http://localhost:8000/`

## Authentication

Most endpoints require authentication via Sanctum. Include the token in the `Authorization` header as `Bearer {token}`. Unauthenticated endpoints are explicitly noted.

### Register

- **URL:** `/register`
- **Method:** `POST`
- **Body:**

  ```json
  {
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string",
    "referral_code": "string (optional)"
  }
  ```
- **Response (201):**

  ```json
  {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "wallet": {
        "id": 1,
        "balance": "10.00",
        "held_balance": "0.00",
        "available_balance": "10.00",
        "updated_at": "2023-10-01T12:00:00Z"
      },
      "created_at": "2023-10-01T12:00:00Z"
    },
    "token": "1|randomtokenstring"
  }
  ```

### Login

- **URL:** `/login`
- **Method:** `POST`
- **Body:**

  ```json
  {
    "email": "string",
    "password": "string"
  }
  ```
- **Response (200):**

  ```json
  {
    "token": "1|randomtokenstring",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "wallet": {
        "id": 1,
        "balance": "10.00",
        "held_balance": "0.00",
        "available_balance": "10.00",
        "updated_at": "2023-10-01T12:00:00Z"
      },
      "created_at": "2023-10-01T12:00:00Z"
    }
  }
  ```

### Logout

- **URL:** `/logout`
- **Method:** `POST`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**

  ```json
  {
    "message": "Successfully logged out"
  }
  ```

## Wallet

### View Wallet

- **URL:** `/wallet`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**

  ```json
  {
    "id": 1,
    "balance": "100.00",
    "held_balance": "20.00",
    "available_balance": "80.00",
    "updated_at": "2023-10-01T12:00:00Z"
  }
  ```

## Referral Codes

### Generate Referral Code

- **URL:** `/referral/generate`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**

  ```json
  {
    "code": "REF123456",
    "message": "Referral code generated successfully"
  }
  ```

### 

## Top-up Requests

### Create Top-up Request

- **URL:** `/top-up`
- **Method:** `POST`
- **Headers:** `Authorization: Bearer {token}`
- **Body:**

  ```json
  {
    "amount": "50.00"
  }
  ```
- **Response (201):**

  ```json
  {
    "id": 1,
    "user_id": 1,
    "user_name": "John Doe",
    "user_email": "john@example.com",
    "amount": "50.00",
    "status": "pending",
    "approved_by_admin_id": null,
    "approved_by_admin_name": null,
    "rejection_reason": null,
    "created_at": "2023-10-01T12:00:00Z",
    "processed_at": null
  }
  ```

### View Top-up Requests

- **URL:** `/top-up-requests`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**

  ```json
  [
    {
      "id": 1,
      "user_id": 1,
      "user_name": "John Doe",
      "user_email": "john@example.com",
      "amount": "50.00",
      "status": "approved",
      "approved_by_admin_id": 1,
      "approved_by_admin_name": "Admin One",
      "rejection_reason": null,
      "created_at": "2023-10-01T12:00:00Z",
      "processed_at": "2023-10-01T12:05:00Z"
    }
  ]
  ```

## Transactions

### View Transactions

- **URL:** `/transactions`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**

  ```json
  [
    {
      "id": 1,
      "wallet_id": 1,
      "amount": "10.00",
      "type": "referral_bonus",
      "request_id": null,
      "request_type": null,
      "created_at": "2023-10-01T12:00:00Z"
    },
    {
      "id": 2,
      "wallet_id": 1,
      "amount": "50.00",
      "type": "top_up",
      "request_id": 1,
      "request_type": "top_up",
      "created_at": "2023-10-01T12:05:00Z"
    }
  ]
  ```

## Error Responses

- **Unauthorized (401):**

  ```json
  {
    "message": "Unauthenticated."
  }
  ```
- **Forbidden (403):**

  ```json
  {
    "message": "Unauthorized"
  }
  ```
- **Validation Error (422):**

  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "email": ["The email field is required."]
    }
  }
  ```