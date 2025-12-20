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
            AKTIFKAN SCANNER
          </button>
          <button id="btnOff"
            class="hidden w-[100%] items-center justify-center gap-3 bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-600 py-4 rounded-2xl font-bold transition-all border border-transparent hover:border-red-100">
            <span>MATIKAN SCANNER</span>
          </button>
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
          <p id="empty-msg" class="col-span-full text-center text-gray-400 py-20 italic">Belum ada member aktif</p>
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

  <script>
    lucide.createIcons();

    const hasil = document.getElementById('hasil');
    const notif = document.getElementById('notif');
    const btnOn = document.getElementById('btnOn');
    const btnOff = document.getElementById('btnOff');
    const customFrame = document.getElementById('custom-frame');
    const activeCount = document.getElementById('active-count');

    const rows = {};
    const timers = {};
    let scanner = null;

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
      scanner.start(
        { facingMode: "environment" },
        { fps: 20, qrbox: 200 },
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
    function onScanSuccess(text) {
      scanner.pause(true);
      const [nama, type] = text.split('|');

      fetch("{{ route('scan.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ nama, type })
      })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'checkin') {
            addMember(nama, type, res.foto, res.timestamp);
            playSound('checkin');
            showNotif(`✅ ${nama} CHECK-IN`);
          }

          if (res.status === 'checkout') {
            removeMember(nama);
            playSound('checkout');
            showNotif(`⏱️ ${nama} CHECK-OUT`);
          }
        })
        .finally(() => {
          setTimeout(() => scanner.resume(), 2000);
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

    function manualCheckout(nama, type) {
      if (!confirm(`Checkout manual untuk ${nama}?`)) return;

      fetch("{{ route('scan.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ nama, type })
      })
        .then(() => {
          removeMember(nama);
          playSound('checkout');
          showNotif(`⏱️ ${nama} CHECK-OUT`);
        });
    }


  </script>

</body>

</html>