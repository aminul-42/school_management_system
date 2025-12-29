<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ARM Academy')</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-p+g7GxL0+9n+q3oB2Fl8jA8FjXOg62lUVkNQfRJx0j9k5Qc2oN+JnNLd6a3WJkHRR6tT0t8b/jxg/ZwtkaOkvA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Fonts & Global Styles --}}
    <style>
        @font-face {
            font-family: 'Berlin Sans FB Demi';
            src: url('{{ asset('frontend/fonts/Berlin_font.TTF') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        body {
            font-family: 'Berlin Sans FB Demi', sans-serif;
            background: #FFF9F9;
            overflow-x: hidden;
            position: relative;
        }

        /* Canvas Background */
        canvas#bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background:transparent;
        }

        



        /* Gradient Text Animation */
        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .gradient-text {
            background-image: linear-gradient(90deg, #6190E8, #000C40, #0f3443, #20002c);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 5s ease infinite;
        }

        /* Gradient Buttons */
        .btn-gradient {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Floating animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        section {
            padding: 5rem 1rem;
        }

        /* Fade-slide animation */
      /* Fade-slide animation */
@keyframes fadeSlideUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-slide-up {
    opacity: 0; /* initially hidden */
    transform: translateY(20px);
    transition: all 0.6s ease-out;
}

.fade-slide-up.visible {
    opacity: 1;
    transform: translateY(0);
    animation: fadeSlideUp 0.8s forwards;
}


    </style>

    @stack('styles')
</head>

<body class="overflow-x-hidden relative">
    <!-- 🧠 Neural Network Animated Background -->
     <!--   <canvas id="bg"></canvas>   -->
    

    {{-- HEADER --}}
    @include('frontend.layouts.partials.header')

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('frontend.layouts.partials.footer1')

    @stack('scripts')

<script>
    const canvas = document.getElementById("bg");
const ctx = canvas.getContext("2d");
canvas.width = innerWidth;
canvas.height = innerHeight;

const words = [
  "Hard Work", "Motivation", "Discipline", "Focus", "Perseverance",
  "Determination", "Courage", "Dedication", "Success", "Inspiration",
  "Growth", "Resilience", "Wisdom", "Effort", "Persistence",
  "Achievement", "Confidence", "Patience", "Ambition", "Leadership"
];


let nodes = [];

function createNode(fadeIn = false) {
  return {
    word: words[Math.floor(Math.random() * words.length)],
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    dx: (Math.random() - 0.5) * 0.3,  // slow horizontal
    dy: (Math.random() - 0.5) * 0.3,  // slow vertical
    size: 20 + Math.random() * 10,
    scale: fadeIn ? 0 : 1,
    alpha: fadeIn ? 0 : 1,
    fadeIn,
    splash: false,
    splashProgress: 0,
    droplets: [],
    swayPhase: Math.random() * Math.PI * 2, // vertical sway phase
    swayAmplitude: 5 + Math.random() * 5,   // vertical sway amount
    swaySpeed: 0.02 + Math.random() * 0.01  // sway speed
  };
}

// Initialize nodes
for (let i = 0; i < 15; i++) nodes.push(createNode());

function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  for (let i = 0; i < nodes.length; i++) {
    let n = nodes[i];

    // horizontal + vertical motion
    n.x += n.dx;
    n.y += n.dy;

    // vertical sway
    n.swayPhase += n.swaySpeed;
    let swayOffset = Math.sin(n.swayPhase) * n.swayAmplitude;

    // bounce from edges
    if (n.x < 0 || n.x > canvas.width) n.dx *= -1;
    if (n.y < 0 || n.y > canvas.height) n.dy *= -1;

    // collision detection with bounding box
    for (let j = i + 1; j < nodes.length; j++) {
      let m = nodes[j];
      ctx.font = `${n.size}px 'Berlin Sans FB Demi', sans-serif`;
      let nWidth = ctx.measureText(n.word).width;
      ctx.font = `${m.size}px 'Berlin Sans FB Demi', sans-serif`;
      let mWidth = ctx.measureText(m.word).width;

      if (!n.splash && !m.splash &&
          n.x + nWidth/2 > m.x - mWidth/2 &&
          n.x - nWidth/2 < m.x + mWidth/2 &&
          n.y + n.size/2 > m.y - m.size/2 &&
          n.y - n.size/2 < m.y + m.size/2
      ) {
        n.splash = true;
        m.splash = true;

        for (let d = 0; d < 6; d++) {
          n.droplets.push({x: n.x, y: n.y, dx: (Math.random()-0.5)*2, dy: Math.random()*2+1, alpha: 1, size: 2+Math.random()*2});
          m.droplets.push({x: m.x, y: m.y, dx: (Math.random()-0.5)*2, dy: Math.random()*2+1, alpha: 1, size: 2+Math.random()*2});
        }
      }
    }

    // Animate splash droplets
    if (n.splash) {
      for (let k = n.droplets.length - 1; k >= 0; k--) {
        let drop = n.droplets[k];
        drop.x += drop.dx;
        drop.y += drop.dy;
        drop.alpha -= 0.02;
        if (drop.alpha <= 0) n.droplets.splice(k, 1);

        ctx.beginPath();
        ctx.arc(drop.x, drop.y, drop.size, 0, Math.PI*2);
        ctx.fillStyle = `rgba(255,255,255,${drop.alpha})`;
        ctx.fill();
      }

      if (n.droplets.length === 0) {
        nodes[i] = createNode(true);
        continue;
      }
      continue;
    }

    // Fade-in + scale-up
    if (n.fadeIn) {
      if (n.alpha < 1) n.alpha += 0.015;
      if (n.scale < 1) n.scale += 0.015;
      if (n.alpha >= 1 && n.scale >= 1) { n.alpha=1; n.scale=1; n.fadeIn=false; }
    }

    // Draw word
    ctx.save();
    ctx.globalAlpha = n.alpha;
    ctx.translate(n.x, n.y + swayOffset);
    ctx.scale(n.scale, n.scale);
    ctx.font = `${n.size}px "Poppins", sans-serif`;
    ctx.fillStyle = "#0f0f0f";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    
    ctx.shadowBlur = 10;
    ctx.fillText(n.word, 0, 0);
    ctx.restore();
  }

  requestAnimationFrame(animate);
}

animate();

// Responsive resize
window.addEventListener("resize", () => {
  canvas.width = innerWidth;
  canvas.height = innerHeight;
});




document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll(".fade-slide-up");

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                obs.unobserve(entry.target); // Animate once
            }
        });
    }, { threshold: 0.1 });

    sections.forEach(section => observer.observe(section));
});


</script>



</body>

</html>