<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Job Board</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --navy: #102a43;
            --text: #64748b;
            --light-blue: #eff6ff;
            --border: #dbe5f1;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            color: var(--navy);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ================= NAVBAR ================= */

        .navbar {
            width: 90%;
            max-width: 1250px;
            margin: 22px auto 0;

            padding: 13px 18px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            background: rgba(255, 255, 255, 0.9);

            border: 1px solid #e7edf5;
            border-radius: 14px;

            box-shadow: 0 8px 30px rgba(15, 42, 67, 0.05);

            position: relative;
            z-index: 10;
        }

        /* LOGO */

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;

            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 14px;
            font-weight: bold;

            background: linear-gradient(
                135deg,
                #2563eb,
                #4f46e5
            );

            box-shadow: 0 7px 18px rgba(37, 99, 235, 0.22);
        }

        .logo-text {
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
        }

        .logo-text span {
            color: var(--blue);
        }

        .logo-text small {
            display: block;

            margin-top: 2px;

            font-size: 9px;
            font-weight: 400;

            color: #94a3b8;
        }

        /* NAV LINKS */

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;

            font-size: 13px;
            color: #64748b;
        }

        .nav-links a {
            position: relative;
            transition: 0.25s;
        }

        .nav-links a:hover {
            color: var(--blue);
        }

        .nav-links .active {
            color: var(--blue);
            font-weight: 600;
        }

        .nav-links .active::after {
            content: "";

            position: absolute;

            left: 50%;
            bottom: -9px;

            width: 5px;
            height: 5px;

            background: var(--blue);

            border-radius: 50%;

            transform: translateX(-50%);
        }

        /* NAV BUTTONS */

        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login {
            padding: 9px 17px;

            border: 1px solid #cbd8e6;
            border-radius: 8px;

            color: #334e68;

            font-size: 12px;
            font-weight: 600;

            background: white;

            transition: 0.25s;
        }

        .btn-login:hover {
            border-color: #93c5fd;
            color: var(--blue);
        }

        .btn-signup {
            padding: 10px 18px;

            border-radius: 8px;

            color: white;

            font-size: 12px;
            font-weight: 600;

            background: var(--blue);

            box-shadow: 0 7px 18px rgba(37, 99, 235, 0.2);

            transition: 0.25s;
        }

        .btn-signup:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
        }

        /* ================= HERO ================= */

        .hero {
            width: 90%;
            max-width: 1250px;

            margin: 55px auto 45px;

            min-height: 455px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            align-items: center;

            gap: 50px;
        }

        /* HERO CONTENT */

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .welcome-text {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 12px;

            border-radius: 30px;

            background: var(--light-blue);
            border: 1px solid #dbeafe;

            color: var(--blue);

            font-size: 12px;
            font-weight: 600;

            margin-bottom: 18px;
        }

        .welcome-text::before {
            content: "✦";

            font-size: 12px;
        }

        .hero h1 {
            font-size: clamp(42px, 5vw, 58px);

            line-height: 1.08;

            letter-spacing: -1.8px;

            color: var(--navy);

            font-weight: 800;

            margin-bottom: 20px;
        }

        .hero h1 span {
            color: var(--blue);
        }

        .hero-description {
            max-width: 510px;

            color: var(--text);

            font-size: 15px;

            line-height: 1.75;

            margin-bottom: 27px;
        }

        /* HERO BUTTON */

        .hero-buttons {
            display: flex;
            gap: 12px;
        }

        .find-job {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;

            padding: 13px 23px;

            border-radius: 9px;

            color: white;

            background: linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            font-size: 13px;
            font-weight: 600;

            box-shadow:
                0 10px 22px rgba(37, 99, 235, 0.22);

            transition: 0.25s;
        }

        .find-job:hover {
            transform: translateY(-2px);

            box-shadow:
                0 14px 28px rgba(37, 99, 235, 0.28);
        }

        /* ================= HERO VISUAL ================= */

        .hero-image {
            min-height: 440px;

            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* BACKGROUND */

        .circle-bg {
            width: 390px;
            height: 390px;

            position: absolute;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    #eef6ff 0%,
                    #f6f9ff 60%,
                    transparent 70%
                );

            right: 20px;
            top: 25px;
        }

        .circle-bg::before {
            content: "";

            position: absolute;

            width: 270px;
            height: 270px;

            border-radius: 50%;

            border: 1px dashed #bfdbfe;

            left: 60px;
            top: 60px;
        }

        /* MAIN CARD */

        .profile-card {
            width: 330px;
            min-height: 225px;

            position: relative;
            z-index: 3;

            background: rgba(255, 255, 255, 0.96);

            border: 1px solid #e1eaf4;

            border-radius: 18px;

            padding: 22px;

            box-shadow:
                0 25px 55px rgba(15, 42, 67, 0.13);

            transform: translateY(-5px);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 20px;
        }

        .card-title {
            font-size: 12px;
            font-weight: 700;
            color: #334e68;
        }

        .ai-status {
            padding: 5px 8px;

            border-radius: 20px;

            background: #f0fdf4;

            color: #16a34a;

            font-size: 8px;
            font-weight: 700;
        }

        /* PROFILE */

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;

            padding-bottom: 18px;

            border-bottom: 1px solid #edf2f7;
        }

        .avatar {
            width: 50px;
            height: 50px;

            border-radius: 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eaf2ff;

            font-size: 22px;
        }

        .profile-info strong {
            display: block;

            color: #243b53;

            font-size: 13px;

            margin-bottom: 4px;
        }

        .profile-info span {
            color: #94a3b8;

            font-size: 9px;
        }

        /* MATCH */

        .match {
            margin-left: auto;

            text-align: center;
        }

        .match strong {
            display: block;

            color: var(--blue);

            font-size: 20px;
        }

        .match span {
            color: #94a3b8;

            font-size: 8px;
        }

        /* SKILLS */

        .skills {
            display: flex;

            gap: 7px;

            margin-top: 17px;
        }

        .skill {
            padding: 6px 9px;

            border-radius: 6px;

            background: #f1f5f9;

            color: #64748b;

            font-size: 8px;
        }

        .skill.ai {
            background: #eff6ff;
            color: var(--blue);
        }

        /* AI FLOATING CARD */

        .ai-card {
            position: absolute;

            right: 20px;
            bottom: 48px;

            width: 155px;

            padding: 15px;

            border-radius: 14px;

            background: #102a43;

            color: white;

            z-index: 5;

            box-shadow:
                0 18px 35px rgba(15, 42, 67, 0.22);

            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-7px);
            }
        }

        .ai-card-title {
            display: flex;
            align-items: center;
            gap: 7px;

            font-size: 9px;
            font-weight: 700;

            margin-bottom: 9px;
        }

        .ai-icon {
            width: 23px;
            height: 23px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            background: var(--blue);

            font-size: 11px;
        }

        .progress {
            width: 100%;
            height: 5px;

            background: #334e68;

            border-radius: 20px;

            overflow: hidden;

            margin: 8px 0;
        }

        .progress span {
            display: block;

            width: 92%;
            height: 100%;

            background: #60a5fa;

            border-radius: 20px;
        }

        .ai-result {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ai-result strong {
            font-size: 16px;
        }

        .ai-result small {
            color: #94a3b8;

            font-size: 7px;
        }

        /* FLOATING SEARCH */

        .search-card {
            position: absolute;

            left: 10px;
            top: 70px;

            z-index: 5;

            padding: 11px 14px;

            display: flex;
            align-items: center;
            gap: 8px;

            background: white;

            border: 1px solid #e5edf5;

            border-radius: 11px;

            box-shadow:
                0 12px 30px rgba(15,42,67,0.1);

            font-size: 9px;

            color: #64748b;
        }

        .search-card span {
            color: var(--blue);
            font-size: 13px;
        }

        /* CHECK */

        .check-card {
            position: absolute;

            left: 80px;
            bottom: 90px;

            width: 34px;
            height: 34px;

            border-radius: 50%;

            background: var(--blue);

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 15px;

            z-index: 5;

            box-shadow:
                0 8px 20px rgba(37,99,235,0.25);
        }

        /* ================= STATS ================= */

        .stats-section {
            width: 100%;

            padding: 30px 5% 38px;

            background:
                linear-gradient(
                    180deg,
                    #f8fbff,
                    #eef6ff
                );

            border-top: 1px solid #edf3f9;
        }

        .stats {
            width: 90%;
            max-width: 1200px;

            margin: auto;

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 16px;
        }

        .stat-card {
            padding: 19px;

            display: flex;
            align-items: center;

            gap: 13px;

            background: white;

            border: 1px solid #e5edf5;

            border-radius: 13px;

            box-shadow:
                0 6px 22px rgba(15,42,67,0.04);

            transition: 0.25s;
        }

        .stat-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 14px 30px rgba(15,42,67,0.08);

            border-color: #cbdff5;
        }

        .stat-icon {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: #eff6ff;

            color: var(--blue);

            font-size: 17px;
        }

        .stat-content h3 {
            color: var(--blue);

            font-size: 18px;

            margin-bottom: 4px;
        }

        .stat-content h4 {
            color: #334e68;

            font-size: 11px;

            margin-bottom: 4px;
        }

        .stat-content p {
            color: #94a3b8;

            font-size: 8px;

            line-height: 1.4;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 950px) {

            .nav-links {
                display: none;
            }

            .hero {
                grid-template-columns: 1fr;

                text-align: center;

                margin-top: 45px;
            }

            .hero-content {
                margin: auto;
            }

            .hero-description {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-image {
                margin-top: -15px;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {

            .navbar {
                width: 94%;
                margin-top: 12px;
            }

            .logo-text {
                font-size: 15px;
            }

            .logo-icon {
                width: 36px;
                height: 36px;
            }

            .btn-login,
            .btn-signup {
                padding: 8px 10px;
                font-size: 10px;
            }

            .hero {
                width: 90%;
                margin-top: 40px;
            }

            .hero h1 {
                font-size: 40px;
            }

            .hero-description {
                font-size: 14px;
            }

            .hero-image {
                min-height: 370px;
                transform: scale(0.9);
            }

            .circle-bg {
                width: 320px;
                height: 320px;
            }

            .profile-card {
                width: 290px;
            }

            .ai-card {
                right: 0;
            }

            .search-card {
                left: 0;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar">

    <a href="{{ url('/') }}" class="logo">

        <div class="logo-icon">
            AI
        </div>

        <div class="logo-text">

            AI <span>Job Board</span>

            <small>
                Find. Match. Grow.
            </small>

        </div>

    </a>



    <div class="nav-buttons">

        <a
            href="{{ route('login') }}"
            class="btn-login"
        >
            Log In
        </a>

        @if (Route::has('register'))

            <a
                href="{{ route('register') }}"
                class="btn-signup"
            >
                Sign Up
            </a>

        @endif

    </div>

</nav>


<!-- ================= HERO ================= -->

<section class="hero">


    <div class="hero-content">

        <div class="welcome-text">
            AI-Powered Job Matching
        </div>


        <h1>

            Find the Right Job.<br>

            Hire the Best
            <span>Talent.</span>

        </h1>


        <p class="hero-description">

            AI Job Board connects talented people with
            the right opportunities. Discover jobs that
            match your skills and take the next step
            in your career.

        </p>


        <div class="hero-buttons">

            <a
                href="{{ url('/register') }}"
                class="find-job"
            >

                <span>⌕</span>

                Find a Job

                <span>→</span>

            </a>

        </div>

    </div>


    <!-- ================= VISUAL ================= -->

    <div class="hero-image">

        <div class="circle-bg"></div>


        <!-- SEARCH FLOAT -->

        <div class="search-card">

            <span>⌕</span>

            Smart Job Search

        </div>


        <!-- MAIN CARD -->

        <div class="profile-card">

            <div class="card-header">

                <div class="card-title">
                    AI Job Match
                </div>

                <div class="ai-status">
                    ● AI Active
                </div>

            </div>


            <div class="profile">

                <div class="avatar">
                    👩‍💻
                </div>


                <div class="profile-info">

                    <strong>
                        Software Developer
                    </strong>

                    <span>
                        Skills matched with this job
                    </span>

                </div>


                <div class="match">

                    <strong>
                        92%
                    </strong>

                    <span>
                        Match
                    </span>

                </div>

            </div>


            <div class="skills">

                <div class="skill ai">
                    Laravel
                </div>

                <div class="skill ai">
                    PHP
                </div>

                <div class="skill">
                    MySQL
                </div>

                <div class="skill">
                    +3
                </div>

            </div>

        </div>


        <!-- AI CARD -->

        <div class="ai-card">

            <div class="ai-card-title">

                <div class="ai-icon">
                    ✦
                </div>

                AI Compatibility

            </div>


            <div style="
                font-size:8px;
                color:#cbd5e1;
            ">

                Your profile matches

            </div>


            <div class="progress">
                <span></span>
            </div>


            <div class="ai-result">

                <strong>
                    92%
                </strong>

                <small>
                    Excellent Match
                </small>

            </div>

        </div>


        <!-- CHECK -->

        <div class="check-card">
            ✓
        </div>

    </div>

</section>


<!-- ================= STATS ================= -->

<section class="stats-section">

    <div class="stats">


        <div class="stat-card">

            <div class="stat-icon">
                💼
            </div>

            <div class="stat-content">

                <h3>
                    10,000+
                </h3>

                <h4>
                    Job Opportunities
                </h4>

                <p>
                    Find opportunities that match your skills.
                </p>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                🏢
            </div>

            <div class="stat-content">

                <h3>
                    5,000+
                </h3>

                <h4>
                    Companies
                </h4>

                <p>
                    Discover and connect with employers.
                </p>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                👥
            </div>

            <div class="stat-content">

                <h3>
                    20,000+
                </h3>

                <h4>
                    Candidates
                </h4>

                <p>
                    Join a growing professional community.
                </p>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                ✦
            </div>

            <div class="stat-content">

                <h3>
                    AI
                </h3>

                <h4>
                    Smart Matching
                </h4>

                <p>
                    Find better opportunities with AI.
                </p>

            </div>

        </div>


    </div>

</section>

</body>
</html>