<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="../css/about.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .about-section {
            padding: 50px;
            background-color: #fff;
            margin: 30px auto;
            max-width: 1200px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .about-header p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 20px;
        }

        .about-header {
            margin-bottom: 40px;
        }

        .team-container {
            background-color: #f9f9f9;
            padding: 40px;
            border-radius: 10px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-container p {
            color: #333;
            font-size: 16px;
            margin: 10px 0;
        }

        .card-container i {
            color: #3498db;
            margin-right: 8px;
        }

        .card-container div {
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .scrolling-images {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            margin: 40px 0;
        }

        .scrolling-images img {
            width: 250px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .video-section {
            text-align: center;
            padding: 50px;
            background-color: #e0f7fa;
            margin-top: 30px;
            border-radius: 10px;
        }

        .video-section video {
            max-width: 90%;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <section class="about-section">
        <div class="about-header">
            <h1>About Us</h1>
            <p>Welcome to <strong>[Your Website Name]</strong>, a platform where creativity meets simplicity. Our website is dedicated to helping creators, artists, and hobbyists showcase their unique crafts and talents, all while earning from what they love to do. Whether you're a professional or just getting started, we believe that everyone deserves a space to shine.</p>
            <p>Our mission is to empower individuals by providing a simple and user-friendly platform to display and sell their handmade crafts. Unlike other platforms, we eliminate the complexities and let your talent speak for itself.</p>
        </div>

        <div class="scrolling-images">
            <img src="https://via.placeholder.com/250x150" alt="Craft Image 1">
            <img src="https://via.placeholder.com/250x150" alt="Craft Image 2">
            <img src="https://via.placeholder.com/250x150" alt="Craft Image 3">
            <img src="https://via.placeholder.com/250x150" alt="Craft Image 4">
        </div>

        <div class="team-container">
            <h2>Why Choose Us?</h2>
            <div class="card-container">
                <div>
                    <i class="fas fa-users"></i><strong>For Everyone:</strong> You don’t need a business profile, professional experience, or a large portfolio to get started. Whether you’re an individual creator, a hobbyist, or a beginner, our platform is open to all.
                </div>
                <div>
                    <i class="fas fa-user-friends"></i><strong>Direct Contact with Buyers:</strong> Once someone is interested in your craft, they can directly reach out to you. No middlemen or hidden processes – just you and your customers.
                </div>
                <div>
                    <i class="fas fa-cogs"></i><strong>Easy to Use:</strong> No complicated procedures or processes. Listing your craft for sale is as simple as a few clicks.
                </div>
                <div>
                    <i class="fas fa-shield-alt"></i><strong>Simple and Secure:</strong> Our platform operates much like OLX, but with a focus on handmade and artistic creations. We ensure a smooth and secure experience for both buyers and sellers.
                </div>
                <div>
                    <i class="fas fa-certificate"></i><strong>No Barriers to Entry:</strong> You don't need a personal business or company to start selling. If you have a passion for crafting, this is your space to share it with the world.
                </div>
                <div>
                    <i class="fas fa-star"></i><strong>Showcase Your Talent:</strong> Our platform allows you to display your artwork and crafts to a wide audience. You can upload your creations, share your story, and connect with potential buyers.
                </div>
            </div>
        </div>
    </section>

    <div class="video-section">
        <h2>Watch Our Journey</h2>
        <video controls>
            <source src="https://www.videvo.net/videvo_files/converted/2016_05/preview/Travel_Video.mp456205.webm" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>
