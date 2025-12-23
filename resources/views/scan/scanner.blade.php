<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>TrackingSpace - Coworking</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://unpkg.com/html5-qrcode"></script>
  <style>
    body {
      background-color: #f3f4f9;
      font-family: 'Inter', sans-serif;
    }

    .bg-purple-main {
      background-color: #6c42c1;
    }

    .text-purple-main {
      color: #6c42c1;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Container Scanner */
    #reader {
      border: none !important;
      position: relative;
      width: 100%;
      overflow: hidden;
      border-radius: 12px;
    }

    #reader video {
      object-fit: cover !important;
    }

    .scanner-container {
      position: relative;
    }

    .scan-frame {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 200px;
      height: 200px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 20px;
      z-index: 10;
      pointer-events: none;
      display: none;
    }

    .scan-frame::before,
    .scan-frame::after,
    .scan-corner-br,
    .scan-corner-bl {
      content: "";
      position: absolute;
      width: 25px;
      height: 25px;
      border-color: #a855f7;
      border-style: solid;
    }

    .scan-frame::before {
      top: -2px;
      left: -2px;
      border-width: 4px 0 0 4px;
      border-top-left-radius: 12px;
    }

    .scan-frame::after {
      top: -2px;
      right: -2px;
      border-width: 4px 4px 0 0;
      border-top-right-radius: 12px;
    }

    .scan-corner-bl {
      bottom: -2px;
      left: -2px;
      border-width: 0 0 4px 4px;
      border-bottom-left-radius: 12px;
    }

    .scan-corner-br {
      bottom: -2px;
      right: -2px;
      border-width: 0 4px 4px 0;
      border-bottom-right-radius: 12px;
    }

    .laser {
      position: absolute;
      width: 100%;
      height: 2px;
      background: linear-gradient(to right, transparent, #a855f7, transparent);
      box-shadow: 0 0 8px #a855f7;
      top: 0;
      animation: scanAnim 2s infinite;
    }

    @keyframes scanAnim {
      0% {
        top: 0;
      }

      50% {
        top: 100%;
      }

      100% {
        top: 0;
      }
    }

    /* Container Scanner yang lebih modern */
    .scanner-card {
      border: 1px solid rgba(108, 66, 193, 0.1);
      transition: transform 0.3s ease;
    }

    /* Efek Overlay di luar kotak scan */
    #reader {
      border: none !important;
      border-radius: 16px;
    }

    /* Kotak Frame Scan yang lebih elegan */
    .scan-frame {
      width: 220px !important;
      height: 220px !important;
      border: 2px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 0 0 4000px rgba(0, 0, 0, 0.4);
      /* Efek fokus */
      border-radius: 24px;
    }

    /* Animasi Laser yang lebih halus */
    .laser {
      height: 3px;
      background: linear-gradient(to right, transparent, #a855f7, #e879f9, #a855f7, transparent);
      box-shadow: 0 0 15px #a855f7;
      animation: scanAnim 2.5s infinite ease-in-out;
    }

    /* Logo Header Box */
    .logo-box {
      background: white;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: space-around;
      padding: 1.5rem;
      box-shadow: 0 4px 15px rgba(108, 66, 193, 0.05);
    }

    .logo-placeholder {
      height: 40px;
      width: auto;
      max-width: 100px;
      object-fit: contain;
    }

    @keyframes scan-slow {

      0%,
      100% {
        top: 5%;
      }

      50% {
        top: 95%;
      }
    }

    .animate-scan-slow {
      position: absolute;
      animation: scan-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Memastikan video memenuhi container */
    #reader video {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover !important;
    }

    /* Sembunyikan pesan default dari library scanner jika ada */
    #reader__dashboard_section_csr button {
      display: none !important;
    }

    /* Line clamp utility */
    .line-clamp-1 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 1;
    }

    .line-clamp-2 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 2;
    }

    .line-clamp-3 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 3;
    }

    /* manual cek in */
    /* Tambahkan di bagian style */
    #searchModal {
      animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .modal-content {
      animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
      from {
        transform: translateY(20px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    /* Scrollbar styling */
    #modalSearchResults::-webkit-scrollbar {
      width: 6px;
    }

    #modalSearchResults::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 3px;
    }

    #modalSearchResults::-webkit-scrollbar-thumb {
      background: #c4b5fd;
      border-radius: 3px;
    }

    #modalSearchResults::-webkit-scrollbar-thumb:hover {
      background: #a78bfa;
    }
  </style>
</head>

<body class="p-4">

  <nav class="flex justify-between items-center mb-6 bg-white p-2 px-4 rounded-xl shadow-sm border border-gray-100">
    <div class="flex items-center gap-2">
      <div class="bg-purple-main p-1.5 rounded-lg text-white">
        <i data-lucide="layout-grid" class="w-6 h-6"></i>
      </div>
      <span class="font-bold text-gray-800 text-xl tracking-tight">Trackingspace</span>
    </div>

    <div class="flex items-center gap-2">
      <!-- Home link tetap di halaman sama (bisa ganti ke target="_blank" kalau mau tab baru) -->
      <a href="{{ route('scan') }}"
        class="flex items-center gap-2 px-4 py-2 text-gray-600 bg-purple-main text-white rounded-lg shadow-md shadow-purple-100 font-medium">
        <i data-lucide="home" class="w-5 h-5"></i>
        <span>Home</span>
      </a>

      <a href="/dashboard"
        class="flex items-center gap-2 px-4 py-2 hover:bg-gray-50 rounded-lg transition-all font-medium">
        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
        <span>Dashboard</span>
      </a>

      <div class="h-8 w-[1px] bg-gray-200 mx-2"></div>

      <div class="bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-bold shadow-sm">
        <i data-lucide="users" class="w-5 h-5"></i>
        <span id="active-count">0</span> Active
      </div>
      <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button
          class="flex items-center gap-2 px-4 py-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all font-medium ml-2">
          <i data-lucide="log-out" class="w-5 h-5"></i>
          <span>Logout (admin)</span>
        </button>
      </form>
    </div>
  </nav>

  <div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 md:col-span-3 space-y-4">
      <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-around">
        <img src="{{ asset('gambar/sl.png') }}" alt="Logo 1" class="h-12 w-auto">
        <div class="h-6 w-[1px] bg-gray-200"></div>
        <img src="{{ asset('gambar/dk.png') }}" alt="Logo 2" class="h-12 w-auto ">
      </div>

      <div class="bg-white rounded-[2rem] p-6 shadow-xl shadow-purple-100/50 border border-purple-50">
        <div class="flex items-center justify-between mb-6">
          <div class="flex flex-col">
            <span class="text-[10px] font-bold text-purple-400 uppercase tracking-[0.2em]">Security Check</span>
            <h3 class="text-gray-800 font-extrabold text-lg">Smart Scan</h3>
          </div>
          <div class="h-10 w-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
            <i data-lucide="qr-code" class="w-6 h-6"></i>
          </div>
        </div>

        <div class="relative aspect-square rounded-[1.5rem] overflow-hidden bg-gray-900 shadow-inner group">
          <div id="reader" class="w-full h-full object-cover scale-x-[-1]"></div>

          <div class="absolute inset-0 pointer-events-none">
            <div
              class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-[2rem] border-[2px] border-white/30 shadow-[0_0_0_1000px_rgba(0,0,0,0.5)]">

              <div
                class="absolute -top-[2px] -left-[2px] w-8 h-8 border-t-4 border-l-4 border-purple-500 rounded-tl-xl">
              </div>
              <div
                class="absolute -top-[2px] -right-[2px] w-8 h-8 border-t-4 border-r-4 border-purple-500 rounded-tr-xl">
              </div>
              <div
                class="absolute -bottom-[2px] -left-[2px] w-8 h-8 border-b-4 border-l-4 border-purple-500 rounded-bl-xl">
              </div>
              <div
                class="absolute -bottom-[2px] -right-[2px] w-8 h-8 border-b-4 border-r-4 border-purple-500 rounded-br-xl">
              </div>

              <div
                class="absolute inset-x-4 top-0 h-[2px] bg-gradient-to-right from-transparent via-purple-400 to-transparent shadow-[0_0_15px_rgba(168,85,247,0.8)] animate-scan-slow">
              </div>
            </div>
          </div>

          <div
            class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/50 backdrop-blur-md px-3 py-1 rounded-full border border-white/10">
            <p class="text-[10px] text-white font-medium flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
              SYSTEM READY
            </p>
          </div>
        </div>

        <div class="mt-6 space-y-3">
          <button id="btnOn"
            class="w-full bg-purple-600 hover:bg-purple-700 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-purple-200 flex items-center justify-center gap-3">
            <i data-lucide="power" class="w-5 h-5"></i>
            ON SCANNER
          </button>
          <button id="btnOff"
            class="hidden w-[100%] items-center justify-center gap-3 bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-600 py-4 rounded-2xl font-bold transition-all border border-transparent hover:border-red-100">
            <span>OFF SCANNER</span>
          </button>
        </div>

        <div class="mt-4">
          <button onclick="openSearchModal()"
            class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white py-3 rounded-2xl font-bold transition-all shadow-lg shadow-purple-200 flex items-center justify-center gap-3">
            <i data-lucide="user-plus" class="w-5 h-5"></i>
            CHECK-IN MANUAL
          </button>

          <!-- Atau tampilkan juga ID input untuk yang suka manual
          <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
            <div class="flex gap-2">
              <input type="text" id="quickId" placeholder="Masukkan ID member (langsung)"
                class="flex-1 p-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
              <button onclick="quickCheckIn()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-bold transition-colors whitespace-nowrap">
                Quick Check-In
              </button>
            </div>
            <p class="text-xs text-blue-600 mt-2 flex items-center gap-1">
              <i data-lucide="info" class="w-3 h-3"></i>
              Klik tombol di atas untuk mencari member
            </p>
          </div> -->
        </div>


        <p id="notif" class="text-center mt-4 text-sm font-bold text-purple-600 min-h-[1.25rem]"></p>
      </div>
    </div>

    <div class="col-span-12 md:col-span-6">
      <div class="card p-4 min-h-[500px]">
        <div
          class="flex items-center gap-2 mb-4 text-purple-main font-semibold border-b pb-2 uppercase tracking-wider text-sm">
          <i data-lucide="users" class="w-5 h-5"></i> Active Members
        </div>
        <div id="hasil" class="grid grid-cols-1 gap-3">
          <p id="empty-msg" class="col-span-full text-center text-gray-400 py-20 italic">Not member active</p>
        </div>
      </div>
    </div>

    <!-- Sidebar Events & Reservations -->
    <div class="col-span-12 md:col-span-3 space-y-4">
      <!-- Upcoming Events Card -->
      <div class="card p-4">
        <div
          class="flex items-center gap-2 mb-4 text-purple-main font-semibold border-b pb-2 uppercase tracking-wider text-sm">
          <i data-lucide="calendar" class="w-5 h-5"></i> Upcoming Events
        </div>

        @if($upcomingEvents->count() > 0)
          <div class="space-y-3">
            @foreach($upcomingEvents as $event)
              <div class="p-3 rounded-lg border border-gray-100 hover:border-purple-200 transition-colors">
                <div class="flex justify-between items-start mb-1">
                  <h4 class="font-bold text-gray-800 text-sm truncate">{{ $event['title'] }}</h4>
                  <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full font-medium">
                    {{ $event['days_until'] }}
                  </span>
                </div>
                <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ $event['description'] ?? 'No description' }}</p>
                <div class="flex items-center text-xs text-gray-400">
                  <i data-lucide="calendar" class="w-3 h-3 mr-1"></i>
                  <span>{{ $event['formatted_date'] }}</span>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="py-10 text-center">
            <div class="text-gray-300 mb-2">
              <i data-lucide="calendar-x" class="w-10 h-10 mx-auto"></i>
            </div>
            <p class="text-gray-400 text-sm italic">No upcoming events</p>
          </div>
        @endif
      </div>

      <!-- Upcoming Reservations Card -->
      <div class="card p-4">
        <div
          class="flex items-center gap-2 mb-4 text-purple-main font-semibold border-b pb-2 uppercase tracking-wider text-sm">
          <i data-lucide="book-open" class="w-5 h-5"></i> Upcoming Reservations
        </div>

        @if($upcomingReservations->count() > 0)
          <div class="space-y-3">
            @foreach($upcomingReservations as $reservation)
              <div class="p-3 rounded-lg border border-gray-100 hover:border-blue-200 transition-colors">
                <div class="flex justify-between items-start mb-1">
                  <h4 class="font-bold text-gray-800 text-sm">{{ $reservation['nama_pemesanan'] }}</h4>
                  <span class="text-xs px-2 py-1 rounded-full font-medium 
                                                                                                      @if($reservation['status'] == 'Confirmed') bg-green-100 text-green-700
                                                                                                      @elseif($reservation['status'] == 'Pending') bg-yellow-100 text-yellow-700
                                                                                                      @else bg-gray-100 text-gray-700
                                                                                                      @endif">
                    {{ $reservation['status'] }}
                  </span>
                </div>
                <p class="text-xs text-gray-500 mb-2">{{ $reservation['purpose'] }}</p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                  <div class="flex items-center text-gray-400">
                    <i data-lucide="calendar" class="w-3 h-3 mr-1"></i>
                    <span>{{ $reservation['formatted_date'] }}</span>
                  </div>
                  <div class="flex items-center text-gray-400">
                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                    <span>{{ $reservation['formatted_time'] }}</span>
                  </div>
                </div>
                <div class="mt-2 text-xs text-gray-400 flex items-center">
                  <i data-lucide="map-pin" class="w-3 h-3 mr-1"></i>
                  <span>{{ $reservation['ruangan'] }}</span>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="py-10 text-center">
            <div class="text-gray-300 mb-2">
              <i data-lucide="calendar-off" class="w-10 h-10 mx-auto"></i>
            </div>
            <p class="text-gray-400 text-sm italic">No upcoming reservations</p>
          </div>
        @endif
      </div>
    </div>
  </div>
  </div>
  <div id="app" data-members='@json($activeMembers)'></div>

  <!-- modal cek in manual -->

  
  <!-- Modal untuk Pencarian Member -->
  <div id="searchModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md max-h-[80vh] overflow-hidden shadow-2xl">
      <!-- Modal Header -->
      <div class="bg-purple-main p-4 text-white">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <i data-lucide="users" class="w-6 h-6"></i>
            <h3 class="font-bold text-lg">Search Member Check-In</h3>
          </div>
          <button onclick="closeSearchModal()" class="hover:bg-purple-700 p-1 rounded-lg transition">
            <i data-lucide="x" class="w-6 h-6"></i>
          </button>
        </div>
      </div>

      <!-- Modal Body -->
      <div class="p-4">
        <!-- Search Input -->
        <div class="relative mb-4">
          <input type="text" id="modalSearchInput" placeholder="Cari berdasarkan nama, email, atau ID..."
            class="w-full p-3 pl-10 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
            onkeyup="searchMembersModal()" />
          <i data-lucide="search" class="absolute left-3 top-3.5 w-5 h-5 text-purple-400"></i>
        </div>

        <!-- Search Results -->
        <div id="modalSearchResults" class="space-y-2 max-h-[300px] overflow-y-auto">
          <!-- Results will be populated here -->
        </div>

        <!-- Loading Indicator -->
        <div id="modalLoading" class="hidden text-center py-8">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div>
          <p class="text-gray-500 mt-2">Searching member...</p>
        </div>

        <!-- Empty State -->
        <div id="modalEmpty" class="hidden text-center py-8">
          <div class="text-gray-300 mb-3">
            <i data-lucide="users" class="w-12 h-12 mx-auto"></i>
          </div>
          <p class="text-gray-500">Search member to start</p>
          <p class="text-gray-400 text-sm mt-1">Typing name, email, or ID member</p>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="border-t p-4 bg-gray-50">
        <div class="flex justify-between items-center">
          <div>
            <p class="text-xs text-gray-500">
              <span id="resultCount">0</span> finds member 
            </p>
          </div>
          <button onclick="closeSearchModal()"
            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>



  <script>
    lucide.createIcons();

    const hasil = document.getElementById('hasil');
    const notif = document.getElementById('notif');
    const btnOn = document.getElementById('btnOn');
    const btnOff = document.getElementById('btnOff');
    const customFrame = document.getElementById('custom-frame');
    const activeCount = document.getElementById('active-count');
    const manualId = document.getElementById('manualId');
    const btnManual = document.getElementById('btnManual');


    const rows = {};
    const timers = {};
    let scanner = null;
    let isProcessing = false;

    const audioIn = new Audio("{{ asset('sounds/jk.mp3') }}");
    const audioOut = new Audio("{{ asset('sounds/ck.mp3') }}");

    // ================= DATA DARI BACKEND =================
    const initialActiveMembers = JSON.parse(
      document.getElementById('app').dataset.members
    );



    document.addEventListener('DOMContentLoaded', () => {
      initialActiveMembers.forEach(m => {
        addMember(m.nama, m.type, m.foto_url, m.timestamp);
      });
      updateActiveCount();
    });

    function playSound(type) {
      const audio = type === 'checkin' ? audioIn : audioOut;
      audio.currentTime = 0;
      audio.play().catch(() => { });
    }

    // ================= CAMERA =================
    function startCamera() {
      scanner = new Html5Qrcode("reader");

      const config = {
        fps: 30,             // Naikkan dari 20 ke 30 untuk gerakan lebih mulus
        qrbox: { width: 250, height: 250 }, // Gunakan objek untuk kontrol lebih presisi
        aspectRatio: 1.0,    // Memastikan frame kamera tidak tertarik (stretch)
        experimentalFeatures: {
          useBarCodeDetectorIfSupported: true // Gunakan akselerasi hardware jika ada
        }
      };

      scanner.start(
        { facingMode: "environment" },
        config,
        onScanSuccess
      ).then(() => {
        btnOn.classList.add('hidden');
        btnOff.classList.remove('hidden');
        customFrame.style.display = 'block';
      });
    }
    function stopCamera() {
      if (!scanner) return;
      scanner.stop().then(() => {
        scanner.clear();
        btnOn.classList.remove('hidden');
        btnOff.classList.add('hidden');
        customFrame.style.display = 'none';
      });
    }

    // ================= SCAN =================
    // ================= SCAN =================
    function onScanSuccess(text) {
      if (isProcessing) return;
      isProcessing = true;

      const id = text;

      fetch("{{ route('scan.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id: id })
      })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'checkout') {
            removeMember(res.nama);
            playSound('checkout');
            showNotif(`⏱️ ${res.nama} CHECK-OUT`);
            if (res.should_remove) refreshActiveMembers();
          }

          if (res.status === 'checkin') {
            addMember(res.nama, res.type, res.foto, res.timestamp);
            playSound('checkin');
            showNotif(`✅ ${res.nama} CHECK-IN`);
          }

          if (res.status === 'error') {
            showNotif(`❌ ${res.message}`);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showNotif('❌ Network error');
        })
        .finally(() => {
          setTimeout(() => { isProcessing = false; }, 2000);
        });
    }

    // Tambahkan fungsi refresh data
    // Tambahkan fungsi refresh yang benar
    function refreshActiveMembers() {
      fetch("{{ route('scan.active.members') }}")
        .then(r => r.json())
        .then(data => {
          // Hapus semua member yang ada
          Object.keys(rows).forEach(nama => {
            if (rows[nama]) {
              clearInterval(timers[nama]);
              delete timers[nama];
              rows[nama].remove();
              delete rows[nama];
            }
          });

          // Reset rows object
          Object.keys(rows).forEach(key => delete rows[key]);

          // Tambahkan member yang aktif dari server
          data.forEach(m => {
            addMember(m.nama, m.type, m.foto_url, m.timestamp);
          });
          updateActiveCount();
        })
        .catch(error => {
          console.error('Refresh error:', error);
        });
    }
    // ================= MEMBER UI =================
    function addMember(nama, type, foto, timestamp) {
      if (rows[nama]) return;

      const item = document.createElement('div');
      item.className = "flex items-center justify-between p-4 card";

      item.innerHTML = `
    <div class="flex items-center gap-3">
      <img src="${foto}" class="w-12 h-12 rounded-full">
      <div>
        <p class="font-bold">${nama}</p>
        <p class="text-xs text-gray-400">${type}</p>
      </div>
    </div>

    <div class="flex items-center gap-4">
      <p id="timer-${nama}" class="font-mono font-bold text-purple-600">0S</p>

      <button
        onclick="manualCheckout('${nama}', '${type}')"
        class="px-3 py-1.5 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
        Checkout
      </button>
    </div>
  `;

      hasil.prepend(item);
      rows[nama] = item;

      const start = new Date(timestamp).getTime();

      timers[nama] = setInterval(() => {
        const diff = Math.floor((Date.now() - start) / 1000);
        updateTimer(nama, diff);
      }, 1000);

      updateActiveCount();
    }

    function removeMember(nama) {
      clearInterval(timers[nama]);
      delete timers[nama];

      rows[nama]?.remove();
      delete rows[nama];

      updateActiveCount();

      if (!Object.keys(rows).length) {
        hasil.innerHTML = `<p class="text-center text-gray-400 py-20 italic">Belum ada member aktif</p>`;
      }
    }

    function updateTimer(nama, s) {
      const el = document.getElementById(`timer-${nama}`);
      if (!el) return;

      const h = Math.floor(s / 3600);
      const m = Math.floor((s % 3600) / 60);
      const d = s % 60;

      el.textContent =
        h > 0 ? `${h}H ${m}M` :
          m > 0 ? `${m}M ${d}S` :
            `${d}S`;
    }

    function updateActiveCount() {
      activeCount.textContent = Object.keys(rows).length;
    }

    function showNotif(msg) {
      notif.textContent = msg;
      notif.className = "text-center mt-3 text-sm font-bold text-purple-600";
      setTimeout(() => notif.textContent = "", 3000);
    }

    btnOn.onclick = startCamera;
    btnOff.onclick = stopCamera;

    // ================= FUNGSI MANUAL CHECK-OUT YANG BENAR =================
    function manualCheckout(nama, type) {
      if (!confirm(`Checkout manual untuk ${nama}?`)) return;

      fetch("{{ route('scan.manual.checkout') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ nama: nama })
      })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'checkout') {
            removeMember(nama);
            playSound('checkout');
            showNotif(`⏱️ ${nama} CHECK-OUT (Manual)`);
          } else if (res.status === 'error') {
            showNotif(`❌ ${res.message}`);
          }
        })
        .catch(err => {
          console.error(err);
          showNotif("❌ Network error");
        });
    }


    // ================= PENCARIAN MEMBER =================
    let searchTimeout = null;

    function searchMembers() {
      const keyword = document.getElementById('searchInput').value.trim();
      const resultsDiv = document.getElementById('searchResults');

      if (!keyword) {
        resultsDiv.classList.add('hidden');
        resultsDiv.innerHTML = '';
        return;
      }

      // Debounce untuk mencegah terlalu banyak request
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        fetch("{{ route('scan.search.members') }}?keyword=" + encodeURIComponent(keyword))
          .then(r => r.json())
          .then(members => {
            displaySearchResults(members);
          })
          .catch(err => {
            console.error('Search error:', err);
          });
      }, 300);
    }

    function displaySearchResults(members) {
      const resultsDiv = document.getElementById('searchResults');

      if (members.length === 0) {
        resultsDiv.innerHTML = `
            <div class="p-4 text-center text-gray-500 bg-white rounded-lg border border-gray-200">
                <i data-lucide="user-x" class="w-8 h-8 mx-auto mb-2"></i>
                <p>Tidak ada member ditemukan</p>
            </div>
        `;
        resultsDiv.classList.remove('hidden');
        return;
      }

      let html = '';
      members.forEach(member => {
        html += `
            <div class="p-3 bg-white rounded-lg border border-gray-200 hover:border-purple-300 hover:shadow-sm transition-all cursor-pointer"
                 onclick="selectMember('${member.id}', '${member.nama.replace(/'/g, "\\'")}')">
                <div class="flex items-center gap-3">
                    <img src="${member.foto_url}" 
                         class="w-10 h-10 rounded-full object-cover">
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">${member.nama}</h4>
                            </div>
                            <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                                ${member.type}
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-xs font-mono bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                ID: ${member.id}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;
      });

      resultsDiv.innerHTML = html;
      resultsDiv.classList.remove('hidden');
    }

    function selectMember(id, nama) {
      // Isi input manual ID
      document.getElementById('manualId').value = id;

      // Tampilkan notifikasi
      showNotif(`✅ ${nama} dipilih (ID: ${id})`);

      // Focus ke input manual ID
      document.getElementById('manualId').focus();

      // Kosongkan hasil pencarian
      document.getElementById('searchResults').innerHTML = '';
      document.getElementById('searchResults').classList.add('hidden');
      document.getElementById('searchInput').value = '';
    }

    // ================= MANUAL CHECK-IN (DIPERBAIKI) =================
    btnManual.addEventListener('click', () => {
      const id = manualId.value.trim();
      if (!id) {
        showNotif("❌ Masukkan ID member!");
        return;
      }
      handleManualCheckIn(id);
    });

    // ================= MANUAL CHECK-IN (DIPERBAIKI UNTUK MODAL) =================
    function handleManualCheckIn(id) {
      if (isProcessing) return;
      isProcessing = true;

      fetch("{{ route('scan.manual.checkin') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id: id })
      })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'checkin') {
            addMember(res.nama, res.type, res.foto, res.timestamp);
            playSound('checkin');
            showNotif(`✅ ${res.nama} CHECK-IN (Manual)`);
            // Refresh data aktif setelah berhasil check-in
            refreshActiveMembers();
          } else {
            showNotif(`❌ ${res.message}`);
          }
        })
        .catch(err => {
          console.error('Error detail:', err);
          showNotif("❌ Network error - periksa koneksi atau server");
        })
        .finally(() => {
          setTimeout(() => { isProcessing = false; }, 1000);
        });
    }

    function selectMemberFromModal(id, nama) {
      closeSearchModal();
      handleManualCheckIn(id);
    }

    // ================= MODAL FUNCTIONS =================
    function openSearchModal() {
      document.getElementById('searchModal').classList.remove('hidden');
      document.getElementById('modalEmpty').classList.remove('hidden');
      document.getElementById('modalSearchResults').classList.add('hidden');
      document.getElementById('modalLoading').classList.add('hidden');
      document.getElementById('modalSearchInput').value = '';
      document.getElementById('modalSearchInput').focus();
      document.body.style.overflow = 'hidden'; // Prevent scrolling
      updateResultCount(0);
    }

    function closeSearchModal() {
      document.getElementById('searchModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    function updateResultCount(count) {
      document.getElementById('resultCount').textContent = count;
    }

    // Search function for modal
    function searchMembersModal() {
      const keyword = document.getElementById('modalSearchInput').value.trim();
      const resultsDiv = document.getElementById('modalSearchResults');
      const loadingDiv = document.getElementById('modalLoading');
      const emptyDiv = document.getElementById('modalEmpty');

      if (!keyword) {
        resultsDiv.classList.add('hidden');
        emptyDiv.classList.remove('hidden');
        loadingDiv.classList.add('hidden');
        updateResultCount(0);
        return;
      }

      // Show loading
      resultsDiv.classList.add('hidden');
      emptyDiv.classList.add('hidden');
      loadingDiv.classList.remove('hidden');

      // Clear previous timeout
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        fetch("{{ route('scan.search.members') }}?keyword=" + encodeURIComponent(keyword))
          .then(r => r.json())
          .then(members => {
            displayModalSearchResults(members);
            loadingDiv.classList.add('hidden');
            updateResultCount(members.length);
          })
          .catch(err => {
            console.error('Search error:', err);
            loadingDiv.classList.add('hidden');
            emptyDiv.classList.remove('hidden');
            emptyDiv.innerHTML = `
                    <div class="text-red-300 mb-3">
                        <i data-lucide="alert-circle" class="w-12 h-12 mx-auto"></i>
                    </div>
                    <p class="text-red-500">Gagal mencari member</p>
                `;
          });
      }, 500);
    }

    function displayModalSearchResults(members) {
      const resultsDiv = document.getElementById('modalSearchResults');
      const emptyDiv = document.getElementById('modalEmpty');

      if (members.length === 0) {
        resultsDiv.classList.add('hidden');
        emptyDiv.classList.remove('hidden');
        emptyDiv.innerHTML = `
            <div class="text-gray-300 mb-3">
                <i data-lucide="user-x" class="w-12 h-12 mx-auto"></i>
            </div>
            <p class="text-gray-500">Tidak ada member ditemukan</p>
            <p class="text-gray-400 text-sm mt-1">Coba kata kunci lain</p>
        `;
        return;
      }

      let html = '';
      members.forEach(member => {
        const isActive = initialActiveMembers.some(m => m.nama === member.nama);

        html += `
            <div class="p-3 bg-white rounded-lg border border-gray-200 hover:border-purple-300 hover:shadow-sm transition-all cursor-pointer ${isActive ? 'opacity-75' : ''}"
                 onclick="${isActive ? '' : `selectMemberFromModal('${member.id}', '${member.nama.replace(/'/g, "\\'")}')`}">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="${member.foto_url}" 
                             class="w-12 h-12 rounded-full object-cover ${isActive ? 'grayscale' : ''}">
                        ${isActive ? `
                            <div class="absolute inset-0 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                            </div>
                        ` : ''}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-gray-800">${member.nama}</h4>
                                <p class="text-xs text-gray-500 truncate max-w-[200px]">${member.email}</p>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-xs ${isActive ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700'} px-2 py-1 rounded-full">
                                    ${member.type}
                                </span>
                                <span class="text-xs ${isActive ? 'text-green-600' : 'text-gray-500'}">
                                    ${isActive ? '✓ Sudah check-in' : 'Belum check-in'}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-500">${member.institusi}</p>
                            <p class="text-xs font-mono bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                ID: ${member.id}
                            </p>
                        </div>
                        ${!isActive ? `
                            <div class="mt-2">
                                <button onclick="event.stopPropagation(); selectMemberFromModal('${member.id}', '${member.nama.replace(/'/g, "\\'")}')"
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm py-2 rounded-lg font-medium transition-colors">
                                    Check-In Sekarang
                                </button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
      });

      resultsDiv.innerHTML = html;
      resultsDiv.classList.remove('hidden');
      emptyDiv.classList.add('hidden');
    }

    function selectMemberFromModal(id, nama) {
      closeSearchModal();
      handleManualCheckIn(id);
    }

    // Quick check-in function
    function quickCheckIn() {
      const id = document.getElementById('quickId').value.trim();
      if (!id) {
        showNotif("❌ Masukkan ID member!");
        return;
      }
      handleManualCheckIn(id);
      document.getElementById('quickId').value = '';
    }

    // Close modal when clicking outside
    document.getElementById('searchModal').addEventListener('click', function (e) {
      if (e.target.id === 'searchModal') {
        closeSearchModal();
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !document.getElementById('searchModal').classList.contains('hidden')) {
        closeSearchModal();
      }
    });

  </script>

</body>

</html>