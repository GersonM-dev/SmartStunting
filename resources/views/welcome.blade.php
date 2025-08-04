<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartStunting Landing Page</title>
  <style>
    /* Soft blue gradient background */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e0f2ff, #f7fbff);
      color: #0353a4;
      overflow-x: hidden;
    }

    .container {
      text-align: center;
      padding: 100px 20px;
    }

    h1 {
      font-size: 3rem;
      margin-bottom: 20px;
      opacity: 0;
      transform: translateY(-30px);
      animation: slideIn 1s forwards ease-out;
    }

    p {
      font-size: 1.2rem;
      margin-bottom: 40px;
      line-height: 1.5;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeIn 1.2s forwards ease-out;
      animation-delay: 0.5s;
    }

    .cta {
      display: inline-block;
      background-color: #a3c4f3;
      color: #fff;
      padding: 15px 40px;
      font-size: 1.1rem;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      text-decoration: none;
      opacity: 0;
      transform: scale(0.8);
      animation: popIn 0.8s forwards ease-out;
      animation-delay: 1s;
    }

    .cta:hover {
      transform: scale(1.05);
    }

    /* Feature Section */
    .features {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 60px;
    }

    .feature {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 20px;
      margin: 10px;
      width: 280px;
      opacity: 0;
      transform: translateY(50px);
      transition: all 0.6s ease-out;
    }

    .feature.visible {
      opacity: 1;
      transform: translateY(0);
    }

    @keyframes slideIn {
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes popIn {
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>SmartStunting</h1>
    <p>Empower growth with data-driven insights. SmartStunting helps you track, analyze, and optimize for smarter decisions.</p>
    <a href="/smartstunting.zip" class="cta" download>Download Now</a>

    <div class="features">
      <div class="feature">
        <h3>Real-time Analytics</h3>
        <p>Visualize your progress instantly with our interactive dashboards.</p>
      </div>
      <div class="feature">
        <h3>Custom Alerts</h3>
        <p>Get notified when key metrics hit your targets.</p>
      </div>
      <div class="feature">
        <h3>Secure Storage</h3>
        <p>Your data is encrypted and backed up automatically.</p>
      </div>
    </div>
  </div>

  <script>
    // Animate feature cards on scroll
    document.addEventListener('DOMContentLoaded', () => {
      const features = document.querySelectorAll('.feature');
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.3 });

      features.forEach(f => observer.observe(f));
    });
  </script>
</body>
</html>
