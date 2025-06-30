<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan Apriori - Dashboard Analisis Market Basket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-navy: #0f172a;
            --accent-teal: #2dd4bf;
            --accent-pink: #ec4899;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            overflow-x: hidden;
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #2dd4bf 0%, #ec4899 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .card-3d {
            transform-style: preserve-3d;
            transition: all 0.5s ease;
        }
        
        .card-3d:hover {
            transform: translateY(-10px) rotateX(5deg);
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-64 h-64 rounded-full bg-[#2dd4bf] opacity-20 filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-[#ec4899] opacity-20 filter blur-3xl translate-x-1/3 translate-y-1/3"></div>
    </div>

    <nav class="relative container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-md bg-gradient-to-br from-teal-400 to-pink-500"></div>
            <span class="text-xl font-bold">Penjualan<span class="gradient-text">Apriori</span></span>
        </div>
        {{-- Arahkan tombol Login ke route /login --}}
        <a href="/login">
        <button class="px-6 py-2 rounded-full bg-gradient-to-r from-teal-400 to-pink-500 text-white font-medium hover:opacity-90 transition-opacity shadow-lg hover:shadow-xl">
            Login
        </button>
        </a>
    </nav>

    <main class="relative container mx-auto px-6 py-16 md:py-24">
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8 z-10">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                    Analisis <span class="gradient-text">Market Basket</span> dengan Algoritma Apriori
                </h1>
                <p class="text-xl text-gray-300 max-w-lg">
                    Temukan pola belanja pelanggan dengan analisis data penjualan berbasis AI dan visualisasi interaktif.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="/login">
                    <button class="px-8 py-3 rounded-full bg-gradient-to-r from-teal-400 to-pink-500 text-white font-medium hover:opacity-90 transition-opacity shadow-lg hover:shadow-xl">
                        Mulai Sekarang
                    </button>
                 </a>
                </div>
            </div>

            <div class="relative z-10">
                <div class="relative h-full flex justify-center">
                    <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-gradient-to-br from-teal-400 to-pink-500 opacity-20 filter blur-xl"></div>
                    <div class="card-3d relative max-w-lg w-full glass-effect p-8 rounded-2xl shadow-2xl">
                        <div class="flex justify-center mb-6">
                            <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/0246b691-25f7-437c-813a-8713522b913e.png" alt="3D rendered dashboard showing colorful sales data visualization with hovering product icons" class="rounded-xl shadow-lg w-full" />
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">Apriori Analysis</h3>
                                <p class="text-sm text-gray-300">Real-time pattern detection</p>
                            </div>
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-teal-400 pulse"></div>
                                <div class="w-3 h-3 rounded-full bg-pink-500 pulse" style="animation-delay: 0.5s;"></div>
                                <div class="w-3 h-3 rounded-full bg-purple-500 pulse" style="animation-delay: 1s;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-10 left-0 w-32 h-32 rounded-full bg-purple-500 opacity-20 filter blur-xl"></div>
                </div>
            </div>
        </section>

        <section class="mt-32">
            <h2 class="text-3xl font-bold text-center mb-12">Key Features</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-3d glass-effect p-6 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Penemuan Pola</h3>
                    <p class="text-gray-300">
                        Temukan hubungan antar produk secara otomatis menggunakan algoritma Apriori terkini.
                    </p>
                </div>
                <div class="card-3d glass-effect p-6 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Visualisasi Interaktif</h3>
                    <p class="text-gray-300">
                        Eksplorasi data dengan visualisasi modern yang memudahkan pemahaman.
                    </p>
                </div>
                <div class="card-3d glass-effect p-6 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-purple-500 to-blue-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Potensi Pendapatan</h3>
                    <p class="text-gray-300">
                        Perkirakan dampak pendapatan dari aturan asosiasi dengan model prediksi akurat.
                    </p>
                </div>
            </div>
        </section>

    </main>

    <footer class="relative mt-32 py-12 border-t border-gray-800">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="w-8 h-8 rounded-md bg-gradient-to-br from-teal-400 to-pink-500"></div>
                    <span class="text-lg font-bold">Penjualan<span class="gradient-text">Apriori</span></span>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card-3d');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach((card, index) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(30px)';
                card.style.transition = `all 0.5s ease ${index * 0.1}s`;
                observer.observe(card);
            });
        });
    </script>
</body>
</html>