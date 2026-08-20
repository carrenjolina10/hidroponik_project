<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Monitoring Dashboard</title>
    <link rel="icon" href="<?php echo e(asset('img/favicon.ico')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

    <div class="bg-decoration"></div>

    <div class="container">

        <aside class="sidebar">
            
            <img src="<?php echo e(asset('img/bagus hidrotext-01.png')); ?>" width=200px>

           <nav>
        <a href="<?php echo e(route('index.index')); ?>" class="active">
            <span class="nav-icon">
                <i data-lucide="layout-dashboard"></i>
            </span>
            Dashboard
        </a>

        <a href="<?php echo e(route('index.create')); ?>">
            <span class="nav-icon">
                <i data-lucide="file-plus-2"></i>
            </span>
            New Data
        </a>

        <a href="<?php echo e(route('data')); ?>">
            <span class="nav-icon">
                <i data-lucide="history"></i>
            </span>
            History
        </a>

        <a href="<?php echo e(url('/ai')); ?>">
                <span class="nav-icon">
                    <i data-lucide="scan-search"></i>
                </span>
                AI Detection
            </a>
    </nav>
        </aside>

        <main class="main">

            <header class="header fade-in delay-1">
                <div class="header-text">
                    <h1>Hydroponic Monitoring</h1>
                    <p>Real-Time Plant Health Analysis</p>
                </div>
                <div class="header-actions">
                    <div class="status-badge">System Online</div>
                </div>
            </header>

            <section class="cards">
                <div class="card fade-in delay-1">
                    <div class="card-icon"><i data-lucide="thermometer"></i></div>
                    <h3>Temperature</h3>
                    <h2>28°C</h2>
                    <div class="card-trend">↑ 2.3% from yesterday</div>
                </div>

                <div class="card fade-in delay-2">
                    <div class="card-icon"><i data-lucide="droplets"></i></div>
                    <h3>pH Water</h3>
                    <h2>6.3</h2>
                    <div class="card-trend" style="color: var(--warning);">↓ 0.1 from optimal</div>
                </div>

                <div class="card fade-in delay-3">
                    <div class="card-icon"><i data-lucide="test-tube-diagonal"></i></div>
                    <h3>Nutrient</h3>
                    <h2>1450 ppm</h2>
                    <div class="card-trend" style="color: var(--danger);">↓ 5% below target</div>
                </div>

                <div class="card fade-in delay-4">
                    <div class="card-icon"><i data-lucide="heart-pulse"></i></div>
                    <h3>Health Score</h3>
                    <h2>92%</h2>
                    <div class="card-trend">↑ 3% this week</div>
                </div>
            </section>

            <section class="content">
                <div class="chart-card fade-in delay-2">
                    <h3>Plant Growth Trend</h3>
                    <div class="chart-wrapper">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>

                <div class="recommendation fade-in delay-3">
                    <div>
                        <h3>🤖 AI Recommendation</h3>
                        <p>
                            Nutrient concentration is slightly low.
                            Add <strong>50 ml Nutrient A</strong> and <strong>45 ml Nutrient B</strong> to restore optimal levels.
                        </p>
                    </div>
                    <button onclick="applySuggestion(this)">
                        Apply Suggestion
                    </button>
                </div>
            </section>

            <section class="status-card fade-in delay-4">
                <h3>Plant Status</h3>
                <div class="status-grid">
                    <div class="status-item">
                        <span>Growth Stage</span>
                        <h4>🌿 Vegetative</h4>
                    </div>
                    <div class="status-item">
                        <span>Plant Age</span>
                        <h4>📅 24 Days</h4>
                    </div>
                    <div class="status-item">
                        <span>Harvest Estimate</span>
                        <h4>🎯 11 Days</h4>
                    </div>
                </div>
            </section>

        </main>

    </div>

    <script>
        // Chart configuration
        const ctx = document.getElementById('growthChart').getContext('2d');
        
        // Create gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(207, 236, 243, 0.6)');
        gradient.addColorStop(1, 'rgba(207, 236, 243, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Growth Index',
                    data: [55, 60, 66, 71, 78, 84, 89],
                    borderColor: '#48bb78',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#48bb78',
                    pointBorderWidth: 3,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#48bb78',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(26, 26, 46, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Growth: ' + context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 40,
                        max: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#718096',
                            font: {
                                family: 'Inter',
                                size: 12
                            },
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#718096',
                            font: {
                                family: 'Inter',
                                size: 12
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Apply suggestion button interaction
        function applySuggestion(btn) {
            btn.innerHTML = '✓ Applied!';
            btn.style.background = 'linear-gradient(135deg, #48bb78, #38a169)';
            btn.style.boxShadow = '0 4px 15px rgba(72, 187, 120, 0.4)';
            
            setTimeout(() => {
                btn.innerHTML = 'Apply Suggestion';
                btn.style.background = '';
                btn.style.boxShadow = '';
            }, 3000);
        }

        // Card hover effects
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Animate numbers on load
        function animateValue(element, start, end, duration, suffix = '') {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);
                element.innerHTML = value + suffix;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Trigger number animations after load
        window.addEventListener('load', () => {
            const cards = document.querySelectorAll('.card h2');
            const values = [28, 6.3, 1450, 92];
            const suffixes = ['°C', '', ' ppm', '%'];
            
            cards.forEach((card, index) => {
                if (index === 1) { // pH value
                    card.innerHTML = '6.3';
                    return;
                }
                const endValue = values[index];
                const suffix = suffixes[index];
                animateValue(card, 0, endValue, 1500, suffix);
            });
        });
    </script>
<script>
    lucide.createIcons();
    </script>

</body>
</html><?php /**PATH C:\Users\Ell_27\Documents\Hidroponik_Bagus\hidroponik_project-main\hidroponik_project-main\resources\views/index.blade.php ENDPATH**/ ?>