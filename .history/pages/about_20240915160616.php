<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="../css/about.css" rel="stylesheet" />
</head>
<body>
    <section class="about-section">
        <div class="about-header">
            <h1>About Us</h1>
            <p>Welcome to [Your Website Name], a platform where creativity meets simplicity. Our website is dedicated to helping creators, artists, and hobbyists showcase their unique crafts and talents, all while earning from what they love to do. Whether you're a professional or just getting started, we believe that everyone deserves a space to shine.</p><br>
            Our mission is to empower individuals by providing a simple and user-friendly platform to display and sell their handmade crafts. Unlike other platforms, we eliminate the complexities and let your talent speak for itself.</p>
        </div>

        <div class="team-container">
            <h2>Meet Our Team</h2>
            <div class="card-container">
                <!-- Card 1 -->
                <div class="team-card">
                    <img src="path/to/image1.jpg" alt="Team Member 1">
                    <div class="card-content">
                        <h3>John Doe</h3>
                        <p>Founder & CEO</p>
                        <button class="read-more-btn" onclick="showBio(1)">Read More</button>
                        <p class="bio" id="bio-1">John has a passion for craftsmanship and has been leading the company since its inception. His vision is to create a space where artisans can shine.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="team-card">
                    <img src="path/to/image2.jpg" alt="Team Member 2">
                    <div class="card-content">
                        <h3>Jane Smith</h3>
                        <p>Lead Designer</p>
                        <button class="read-more-btn" onclick="showBio(2)">Read More</button>
                        <p class="bio" id="bio-2">Jane is the creative force behind our designs, ensuring each product is crafted with care and style.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="team-card">
                    <img src="path/to/image3.jpg" alt="Team Member 3">
                    <div class="card-content">
                        <h3>Michael Lee</h3>
                        <p>Marketing Director</p>
                        <button class="read-more-btn" onclick="showBio(3)">Read More</button>
                        <p class="bio" id="bio-3">With over 10 years in the marketing industry, Michael is helping us reach new heights.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function showBio(id) {
            const bioElement = document.getElementById(`bio-${id}`);
            bioElement.classList.toggle('visible');
        }
    </script>
</body>
</html>