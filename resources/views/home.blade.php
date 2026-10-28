<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pink Petals | Flower Shop</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink: #d95785;
            --dark-pink: #71354c;
            --light-pink: #fff0f3;
            --cream: #fffaf7;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--cream);
            color: #49313b;
            font-family: 'DM Sans', sans-serif;
        }

        h1, h2, h3, h4, .brand {
            font-family: 'Playfair Display', serif;
        }

        

        .navbar {
            background: rgba(255, 250, 247, 0.97);
            padding: 16px 0;
            border-bottom: 1px solid #f7e3e8;
        }

        .brand {
            color: var(--pink);
            font-size: 30px;
            font-style: italic;
            font-weight: 700;
            text-decoration: none;
        }

        .brand small {
            display: block;
            text-align: center;
            font: 9px 'DM Sans', sans-serif;
            letter-spacing: 3px;
            color: var(--dark-pink);
        }

        .nav-link {
            color: #49313b;
            margin: 0 10px;
            font-size: 14px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--pink);
        }

        .hero {
            background: linear-gradient(110deg, #ffe8ed, #fff1ed);
            overflow: hidden;
        }

        .hero-content {
            padding: 75px 0;
        }

        .eyebrow {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--dark-pink);
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 62px);
            font-weight: 700;
            line-height: 1.15;
            margin: 18px 0;
        }

        .pink-text {
            color: var(--pink);
            font-style: italic;
        }

        .hero p {
            color: #735f68;
            line-height: 1.8;
            max-width: 440px;
        }

        .hero-image {
            width: 100%;
            height: 390px;
            object-fit: cover;
            border-radius: 0;
        }

        .btn-pink {
            display: inline-block;
            background: var(--pink);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 27px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-pink:hover {
            background: var(--dark-pink);
            color: white;
            transform: translateY(-2px);
        }

        .section {
            padding: 65px 0;
            scroll-margin-top: 90px;
        }

        

        .section-title h2 {
            font-weight: 700;
            margin: 10px 0;
        }

        

        .products-section {
            background: #fff0f4;
        }

        .product-card {
            height: 100%;
            background: white;
            padding: 10px;
            border: 1px solid #f6e2e8;
            border-radius: 0;
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px #71354c12;
        }

        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 0;
            background: var(--light-pink);
        }

        .product-name {
            font-size: 17px;
            margin: 13px 0 5px;
        }

        .rating {
            color: #f0a344;
            font-size: 13px;
        }

        .price {
            color: var(--pink);
            font-weight: 700;
            margin: 8px 0;
        }

        .gift-banner {
            background: linear-gradient(100deg, #f9dce5, #fff0f2);
            border-radius: 0;
            overflow: hidden;
        }

        .gift-banner img {
            width: 100%;
            height: 260px;
            object-fit: cover;
        }

        .gift-content {
            padding: 30px;
        }

        .about-section {
            background: white;
            text-align: center;
        }

        .about-section p {
            max-width: 700px;
            margin: auto;
            color: #806d75;
            line-height: 1.9;
        }

        .service {
            text-align: center;
            padding: 20px 5px;
        }

        .service-icon {
            font-size: 28px;
            color: var(--pink);
        }

        footer {
            background: #633448;
            color: white;
            padding: 35px 0 20px;
        }

        footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
        }

        footer a:hover {
            color: #ffc3d5;
        }

        @media (max-width: 768px) {
            .hero-content {
                padding: 45px 20px;
            }

            .hero-image {
                height: 300px;
                margin-bottom: 25px;
            }

            .category-card img {
                height: 150px;
            }

            .product-image {
                height: 180px;
            }

            .gift-banner img {
                height: 200px;
            }
        }
    </style>
</head>

<body>

    <!-- Top Announcement -->
    

    <!-- Navigation: Only Four Menus -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="brand" href="#home">
                🌸 Pink Petals
                <small>FLOWER SHOP</small>
            </a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Products</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <div class="eyebrow">Fresh Flowers, Happy Moments ♥</div>

                    <h1>
                        Say it with<br>
                        beautiful <span class="pink-text">flowers.</span>
                    </h1>

                    <p>
                        Every petal tells a story. Find the perfect bouquet
                        to celebrate love, friendship, birthdays and all
                        of life's little moments.
                    </p>

                    <a href="#products" class="btn-pink mt-3">
                        Shop Now &nbsp; →
                    </a>
                </div>

            <div class="col-lg-6">
                    <img src="{{ asset('images/hero4.jpg') }}"
                         alt="Beautiful flower bouquet"
                         class="hero-image">
                </div>
            </div>
        </div>
    </section>

    
    

</body>
</html>
