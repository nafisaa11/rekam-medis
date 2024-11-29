<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <style>
        body {
    background: linear-gradient(to right, #e3f2fd, #bbdefb);
  }

  .sidebar {
    background: linear-gradient(to bottom, #2196f3, #1976d2);
    color: white;
    min-height: 100vh;
  }

  .sidebar .admin-image {
    width: 100px;
    height: 100px;
    border: 3px solid white;
  }

  .sidebar h3 {
    font-size: 1.5rem;
    font-weight: 600;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
  }

  .menu-item {
    transition: all 0.3s;
    padding: 10px 20px;
    border-radius: 8px;
  }

  .menu-item:hover {
    background: rgba(255, 255, 255, 0.1);
    cursor: pointer;
  }

  .menu-item i {
    font-size: 1.2rem;
    margin-right: 10px;
  }

  .logout-btn {
    background: white;
    color: #1976d2;
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
    text-decoration: none;
  }

  .logout-btn:hover {
    transform: scale(1.1);
  }
    </style>
  </head>

  <body>
    <div class="d-flex">
      <!-- Sidebar -->
      