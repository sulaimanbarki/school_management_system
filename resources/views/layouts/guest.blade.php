<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School Management System') }} - Admin Login</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-glow: rgba(79, 70, 229, 0.4);
            --accent: #3b82f6;
            --success: #10b981;
            --danger: #ef4444;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --bg-card: rgba(255, 255, 255, 0.95);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 10% 20%, rgba(79, 70, 229, 0.4) 0px, transparent 50%),
                radial-gradient(at 90% 80%, rgba(59, 130, 246, 0.35) 0px, transparent 50%),
                linear-gradient(135deg, rgba(15, 23, 42, 0.82) 0%, rgba(20, 20, 48, 0.85) 50%, rgba(15, 23, 42, 0.9) 100%),
                url('{{ asset('login_bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 24px 16px;
        }

        /* Ambient glowing background orbs */
        .ambient-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.6;
            animation: pulseOrb 8s ease-in-out infinite alternate;
        }

        .orb-1 {
            width: 450px;
            height: 450px;
            background: linear-gradient(135deg, #4f46e5, #8b5cf6);
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            bottom: -150px;
            right: -150px;
            animation-delay: -4s;
        }

        @keyframes pulseOrb {
            0% { transform: scale(1) translate(0, 0); opacity: 0.45; }
            100% { transform: scale(1.15) translate(30px, 20px); opacity: 0.7; }
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: entranceSlide 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes entranceSlide {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .glass-card {
            width: 100%;
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 28px;
            padding: 44px 40px;
            box-shadow: 
                0 25px 60px -15px rgba(0, 0, 0, 0.45),
                0 0 0 1px rgba(255, 255, 255, 0.25),
                inset 0 1px 2px rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4f46e5, #3b82f6, #06b6d4, #4f46e5);
            background-size: 300% 100%;
            animation: gradientBorder 6s linear infinite;
        }

        @keyframes gradientBorder {
            0% { background-position: 0% 50%; }
            100% { background-position: 300% 50%; }
        }

        .footer-brand {
            margin-top: 24px;
            text-align: center;
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            font-weight: 500;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .footer-brand i {
            color: #38bdf8;
        }

        @media (max-width: 640px) {
            .glass-card {
                padding: 32px 24px;
                border-radius: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="ambient-orb orb-1"></div>
    <div class="ambient-orb orb-2"></div>

    <div class="login-wrapper">
        {{ $slot }}

        <div class="footer-brand">
            <i class="fas fa-shield-halved"></i>
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'School Management System') }}. All rights reserved.</span>
        </div>
    </div>
</body>

</html>