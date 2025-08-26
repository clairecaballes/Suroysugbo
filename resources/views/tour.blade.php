<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Explore Cebu</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Iconscout Icons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
  <!-- Add this in the <head> section -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- External Stylesheet -->
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }

    body {
      background-color: #ffffff;
      color: #1a1a1a;
      line-height: 1.7;
    }

    nav {
      background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
      color: white;
      padding: 1.25rem 0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .nav_container {
      max-width: 1400px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 2rem;
    }

    .nav_container h4 {
      font-size: 1.75rem;
      font-weight: 700;
      background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .nav_menu a {
      text-decoration: none;
      color: #e2e8f0;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .nav_menu a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #ffffff;
    }

    /* Modern Section Styles */
    section {
      padding: 6rem 2rem;
      position: relative;
    }

    section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.1), transparent);
    }

    /* Card Styles */
    .card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    /* Button Styles */
    .btn {
      padding: 1rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-primary {
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* Form Styles */
    input, select, textarea {
      width: 100%;
      padding: 1rem;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      transition: all 0.3s ease;
      font-size: 1rem;
    }

    input:focus, select:focus, textarea:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
      outline: none;
    }

    /* Typography */
    h1, h2, h3, h4, h5, h6 {
      color: #1e3a8a;
      line-height: 1.3;
    }

    /* Container */
    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    /* Media Queries */
    @media (max-width: 1024px) {
      section {
        padding: 4rem 1.5rem;
      }
      
      .container {
        padding: 0 1.5rem;
      }
    }

    @media (max-width: 768px) {
      .nav_container {
        padding: 0 1.5rem;
      }

      section {
        padding: 3rem 1rem;
      }
      
      .container {
        padding: 0 1rem;
      }

      .btn {
        padding: 0.875rem 1.75rem;
      }
    }

    /* Header Section */
    .header {
      padding: 4rem 1rem;
      background-color: #061e36;
    }

    .header-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      max-width: 1200px;
      margin: auto;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .header-left {
      flex: 1;
    }

    .header-left h1 {
      font-size: 2.5rem;
      color: #007bff;
      margin-bottom: 1rem;
    }

    .header-left p {
      font-size: 1.1rem;
      color: #ffffff;
      margin-bottom: 2rem;
      line-height: 1.6;
    }

    .btn-primary {
      background-color: #4fa7ff;
      color: white;
      padding: 0.75rem 1.75rem;
      border: none;
      border-radius: 30px;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .header-right {
      flex: 1;
      display: flex;
      justify-content: center;
    }

    .header-image {
      width: 100%;
      max-width: 500px;
      border-radius: 0;
      /* No border or rounded corners */
      box-shadow: none;
      /* Remove any shadow if present */
    }

    @media (max-width: 768px) {
      .header-container {
        flex-direction: column-reverse;
        text-align: center;
      }

      .header-left h1 {
        font-size: 2rem;
      }

      .header-left p {
        font-size: 1rem;
      }

      .header-image {
        max-width: 100%;
        margin-top: 2rem;
      }
    }



    .slider-section {
      padding: 4rem 1rem;
      text-align: center;
    }

    .slider-title {
      font-size: 2rem;
      margin-bottom: 2rem;
    }

    .slider-wrapper {
      overflow: hidden;
      position: relative;
    }

    .slider-track {
      display: flex;
      transition: transform 0.3s ease-in-out;
    }

    .slider-item {
      flex: 0 0 auto;
      width: 300px;
      margin-right: 1rem;
    }

    .slider-image {
      width: 100%;
      border-radius: 12px;
    }

    .slider-description {
      margin-top: 0.5rem;
      font-weight: 500;
    }

    .arrow-buttons {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }

    .arrow-btn {
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      padding: 0.5rem;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .compact-contact {
      background: #fff;
      padding: 3rem 1rem;
      display: flex;
      justify-content: center;
    }

    .contact-card {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      max-width: 1000px;
      width: 100%;
    }

    .contact-left,
    .contact-right {
      flex: 1 1 300px;
    }

    .contact-left img {
     
  width: 100%;

    }

    .contact-right input,
    .contact-right select,
    .contact-right textarea {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      border-left: 6px solid #007bff;
    }

    .contact-right button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
    }



    .user-ratings {
      padding: 4rem 1rem;
  
      text-align: center;
    }

    .reviews-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.5rem;
    }

    .review-card {
      background-color: #f8f8f8;
      border-radius: 12px;
      padding: 1.5rem;
      width: 300px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .review-header {
      display: flex;
      justify-content: space-between;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .signup-cta {
      margin-top: 2rem;
    }

    @media (max-width: 768px) {
      .nav_menu {
        display: none;
        flex-direction: column;
        background: #007bff;
        padding: 1rem;
        position: absolute;
        top: 70px;
        right: 0;
        width: 200px;
      }

      .header_container {
        flex-direction: column-reverse;
        text-align: center;
      }

      .slider-item {
        width: 80vw;
      }

      .contact-card {
        flex-direction: column;
      }
    }

    #close-menu-btn {
      display: none;
    }

    #open-menu-btn {
      background: none;
      border: none;
      font-size: 1.8rem;
      color: white;
      display: none;
      cursor: pointer;
    }

    .nav_menu {
      display: flex;
      list-style: none;
      gap: 1.5rem;
    }

    @media (max-width: 768px) {
      .nav_menu {
        display: none;
        flex-direction: column;
        background: #007bff;
        position: absolute;
        top: 70px;
        right: 1rem;
        width: 200px;
        padding: 1rem;
        z-index: 1000;
      }

      .nav_menu.active {
        display: flex;
      }

      #open-menu-btn {
        display: block;
      }

      #close-menu-btn {
        display: none;
      }

      .nav_container.show-menu #open-menu-btn {
        display: none;
      }

      .nav_container.show-menu #close-menu-btn {
        display: block;
      }
    }
  </style>

  @routes
  @vite(['resources/js/tour.ts', "resources/js/pages/{$page['component']}.vue"])
  @inertiaHead
</head>

<body>
  @inertia

  <script type="text/javascript" src="{{ URL::asset('/js/main.js')}}"></script>
</body>

</html>