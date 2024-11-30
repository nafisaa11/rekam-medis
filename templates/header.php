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
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&display=swap" />
  <style>
    body,
    h1,
    h2,
    h3,
    h4,
    p,
    button,
    input {
      font-family: 'Kanit', sans-serif;
    }

    /* Konfigurasi font */
    h1 {
      font-weight: 500;
      font-style: normal;
      font-size: 44px;
    }

    h2 {
      font-weight: 500;
      font-style: normal;
      font-size: 32px;
    }

    h3 {
      font-weight: 500;
      font-style: normal;
      font-size: 24px;
    }

    h4,
    th {
      font-weight: 500;
      font-style: normal;
      font-size: 16px;
    }

    label {
      font-weight: 400;
      font-style: normal;
      font-size: 16px;
    }

    ::placeholder,
    input.form-control,
    b,
    td {
      font-weight: 300;
      font-style: normal;
      font-size: 16px;
    }

    body {
      background: linear-gradient(to right, #e3f2fd, #bbdefb);
    }

    /* Konfigurasi sidebar */
    .sidebar {
      background: linear-gradient(to bottom, #2196f3, #1976d2);
      color: white;
      min-height: 100vh;
      width: 225px;
    }

    .sidebar .admin-image {
      width: 100px;
      height: 100px;
      border: 3px solid white;
    }

    .sidebar h3 {
      font-size: 1.5rem;
      font-weight: 500;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
    }

    .menu-item {
      transition: all 0.3s;
      padding: 10px 20px;
      border-radius: 8px;
      /* background: rgba(25, 118, 210, 1); */
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

    /* Konfigurasi ikon */
    .fa-eye,
    .fa-pen-to-square {
      color: #2196f3;
      transition: color 0.3s;
    }

    .fa-eye:hover,
    .fa-pen-to-square:hover {
      color: #1976d2;
    }

    .custom-btn {
      background-color: #2196f3;
      transition: color 0.3s;
    }

    .custom-btn:hover {
      background-color: #1976d2;
    }

    /* Konfigurasi pagination */
    .pagination .page-item.active .page-link,
    .pagination .page-link:hover {
      background-color:#2196f3;
      color: white;
    }

  </style>
</head>

<body>
  <div class="d-flex">