<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>UTHM Campus Event Management System</title>

    <link rel="icon" href="{{ asset('uploads/logo/logo_system.png') }}" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    html {
        scroll-behavior: smooth;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: url('{{ asset('uploads/logo/background2.png') }}') center center / cover no-repeat fixed;
        color: #111;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }
    .overlay {
        background: rgba(255, 255, 255, 0.7);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
    }
    nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 15px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 3;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .nav-logo {
        height: 50px;
    }
    .nav-links {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .nav-links a {
        color: #111;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        padding: 6px 12px;
        border-radius: 6px;
    }
    .nav-links a:hover {
        color: #FFC107;
    }
    .nav-links a.active {
        border-color: #FFC107;
        color: #FFC107;
    }

    .container {
        z-index: 2;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 160px 20px 80px;
        animation: fadeIn 1s ease-out;
    }
    .welcome-text {
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 20px;
        max-width: 900px;
        line-height: 1.2;
        color: #111;
    }

    /* ONLY font changed here for subtitle */
    .subtitle {
        font-family: 'Rubik', sans-serif;
        font-size: 1.5rem;
        font-weight: 500;
        max-width: 700px;
        margin-bottom: 40px;
        /* Keep original color - no change */
        color: #333;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.6);
    }

    .button-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .button-group a {
        background: linear-gradient(135deg, #FFC107, #FFB300);
        color: #111;
        padding: 14px 36px;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }
    .button-group a:hover {
        background: #fff;
        color: #000;
        transform: translateY(-3px);
    }

    .section {
        z-index: 2;
        position: relative;
        padding: 60px 20px;
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
    }

    /* ONLY font changed here for section titles */
    .section h2 {
        font-family: 'Rubik', sans-serif;
        font-size: 2.8rem;
        margin-bottom: 20px;
        /* Keep original color - no change */
        color: #3F51B5;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .section p {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #333;
    }
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .info-card {
        background: #fff;
        padding: 30px 20px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-8px);
    }
    .info-card h3 {
        font-size: 1.6rem;
        margin-bottom: 10px;
        color: #FFB300;
        font-weight: 700;
    }
    .info-card p {
        font-size: 1rem;
        color: #333;
    }

    footer {
        z-index: 2;
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        padding: 40px 20px 20px;
    }
    footer a {
        color: #666;
        text-decoration: none;
    }
    footer a:hover {
        text-decoration: underline;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .welcome-text {
            font-size: 2.5rem;
        }
        .subtitle {
            font-size: 1.2rem;
        }
        nav {
            flex-direction: column;
            align-items: flex-start;
        }
        .nav-links {
            flex-wrap: wrap;
        }
    }
</style>
</head>
<body>
    <div class="overlay"></div>

    <nav>
        <img src="{{ asset('uploads/logo/logo_system.png') }}" alt="UTHM Logo" class="nav-logo" />
        <div class="nav-links">
            <a href="#vision">Vision & Mission</a>
            <a href="#about">About</a>
            <a href="#features">Key Features</a>
            <a href="#who">Who Can Use?</a>
            <a href="#help">Help</a>
            <a href="{{ route('login') }}">Log In</a>
            <a href="{{ route('register') }}">Register</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="welcome-text">UTHM CAMPUS EVENT MANAGEMENT SYSTEM</h1>
        <p class="subtitle">
            Empowering Campus Life Through Events by Manage, Discover, and Participate in Events at UTHM — All in One Platform
        </p>

        @if (Route::has('login'))
            <div class="button-group">
                @auth
                <a href="{{ url('/dashboard') }}">Go to Dashboard</a>
                @else
                <a href="{{ route('login') }}">Log In</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                @endif
                @endauth
            </div>
        @endif
    </div>

    <div class="section" id="vision">
        <h2>Our Vision & Mission</h2>
        <div class="card-grid">
            <div class="info-card">
                <h3>🎯 Vision</h3>
                <p>
                    The UTHM Campus Event Management System aims to be a centralized and dynamic platform that empowers student engagement and fosters a vibrant,
                    inclusive campus culture.
                </p>
            </div>
            <div class="info-card">
                <h3>🚀 Mission</h3>
                <p>
                    Our mission is to streamline the planning, management, and participation of campus events by integrating all stakeholders into one cohesive platform.
                </p>
            </div>
        </div>
    </div>

    <div class="section" id="about">
        <h2>About the System</h2>
        <p>
            This system simplifies how events are managed at UTHM. From registration and scheduling to collecting feedback and sending reminders — everything happens here.
            Students, clubs, and administrators can collaborate easily and efficiently.
        </p>
    </div>

    <div class="section" id="features">
        <h2>Key Features</h2>
        <div class="card-grid">
            <div class="info-card">
                <h3>📅 Centralized Event Listings</h3>
                <p>Find all upcoming events in one place.</p>
            </div>
            <div class="info-card">
                <h3>⚡ Real-Time Calendar</h3>
                <p>Stay updated with a live event calendar.</p>
            </div>
            <div class="info-card">
                <h3>💳 Online Registration & Payments</h3>
                <p>Register and pay securely online.</p>
            </div>
            <div class="info-card">
                <h3>⭐ Feedback & Ratings</h3>
                <p>Share your event experience and help improve.</p>
            </div>
            <div class="info-card">
                <h3>📧 Email Reminders</h3>
                <p>Get notified about your registered events.</p>
            </div>
            <div class="info-card">
                <h3>🔐 Role-based Access</h3>
                <p>Students, organizers, and admins have tailored access.</p>
            </div>
        </div>
    </div>

    <div class="section" id="who">
        <h2>Who Can Use This System?</h2>
        <div class="card-grid">
            <div class="info-card">
                <h3>🎓 Students</h3>
                <p>Explore, register, and give feedback on events.</p>
            </div>
            <div class="info-card">
                <h3>🏛 Organizers</h3>
                <p>Propose and manage events, collect feedback.</p>
            </div>
            <div class="info-card">
                <h3>🧑‍💼 HEP Staff & MPP</h3>
                <p>Review event proposals and generate detailed reports.</p>
            </div>
        </div>
    </div>

    <div class="section" id="help">
        <h2>Need Help?</h2>
        <p>
            For support, contact <a href="mailto:support@uthm.edu.my" style="color: #FFC107;">support@uthm.edu.my</a><br />
            Or visit the
            <a href="https://hep.uthm.edu.my" target="_blank" style="color: #FFC107;">PHEP Official Portal</a>
        </p>
    </div>

    <footer>
        &copy; {{ date('Y') }} UTHM Campus Event Management System. Designed for better student engagement.
    </footer>

    <script>
        const navLinks = document.querySelectorAll('.nav-links a');

        function setActiveLink() {
            navLinks.forEach((link) => link.classList.remove('active'));
            let currentSection = null;
            document.querySelectorAll('.section').forEach((section) => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= 100 && rect.bottom >= 100) {
                    currentSection = section;
                }
            });
            if (currentSection) {
                const id = currentSection.getAttribute('id');
                const activeLink = document.querySelector(`.nav-links a[href="#${id}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }
        }

        window.addEventListener('scroll', setActiveLink);
        window.addEventListener('load', setActiveLink);
    </script>
</body>
</html>
