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
      <a href="#"
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
      <div class="card bg-purple-main p-6 text-white">
        <h2 class="text-2xl font-bold">Trasa</h2>
        <p class="opacity-80">Coworking Space</p>
      </div>

      <div class="card p-4">
        <div class="flex items-center gap-2 mb-4 text-purple-main font-semibold">
          <i data-lucide="maximize" class="w-5 h-5"></i> Scan to Check-in/out
        </div>

        <div class="scanner-container">
          <div id="reader"></div>
          <div id="custom-frame" class="scan-frame">
            <div class="laser"></div>
            <div class="scan-corner-bl"></div>
            <div class="scan-corner-br"></div>
          </div>
        </div>

        <div class="mt-4 space-y-2">
          <button id="btnOn"
            class="w-full bg-purple-main text-white py-3 rounded-lg font-bold shadow-lg shadow-purple-200 uppercase tracking-wide">START
            CAMERA</button>
          <button id="btnOff"
            class="hidden w-full bg-red-500 text-white py-3 rounded-lg font-bold shadow-lg uppercase tracking-wide">DISABLE
            CAMERA</button>
        </div>
        <p id="notif" class="text-center mt-3 text-sm font-bold h-6 transition-all duration-300"></p>
        <p class="text-center text-xs text-gray-400 mt-2">Siap melakukan scan</p>
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

    <div class="col-span-12 md:col-span-3 space-y-4">
      <div class="card p-4">
        <div
          class="flex items-center gap-2 mb-4 text-purple-main font-semibold border-b pb-2 uppercase tracking-wider text-sm">
          <i data-lucide="calendar" class="w-5 h-5"></i> Upcoming Events
        </div>
        <div class="py-10 text-center">
          <p class="text-gray-400 text-sm italic">No upcoming events</p>
        </div>
      </div>
      <div class="card p-4">
        <div
          class="flex items-center gap-2 mb-4 text-purple-main font-semibold border-b pb-2 uppercase tracking-wider text-sm">
          <i data-lucide="book-open" class="w-5 h-5"></i> Upcoming Reservations
        </div>
        <div class="py-10 text-center">
          <p class="text-gray-400 text-sm italic">No upcoming reservations</p>
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

    // Menangani error audio jika file tidak ditemukan
    const audioIn = new Audio("{{ asset('sounds/jk.mp3') }}");
    const audioOut = new Audio("{{ asset('sounds/ck.mp3') }}");

    const timers = {};
    const rows = {};
    let scanner = null;

    function playSound(type) {
      const audio = (type === 'checkin') ? audioIn : audioOut;
      audio.currentTime = 0;
      audio.play().catch(e => console.log("Audio play blocked or not found"));
    }

    function startCamera() {
      scanner = new Html5Qrcode("reader");
      const config = { fps: 20, qrbox: { width: 200, height: 200 }, aspectRatio: 1.0 };

      scanner.start({ facingMode: "environment" }, config, onScanSuccess)
        .then(() => {
          btnOn.classList.add('hidden');
          btnOff.classList.remove('hidden');
          customFrame.style.display = 'block';
        })
        .catch(err => alert("Gagal akses kamera: " + err));
    }

    function stopCamera() {
      if (scanner) {
        scanner.stop().then(() => {
          scanner.clear();
          btnOn.classList.remove('hidden');
          btnOff.classList.add('hidden');
          customFrame.style.display = 'none';
        });
      }
    }

    function onScanSuccess(decodedText) {
      if (navigator.vibrate) navigator.vibrate(100);
      scanner.pause(true);
      const [nama, type] = decodedText.split('|');

      fetch("{{ route('scan.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ nama, type })
      })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'checkin') {
            addMemberToList(nama, type, res.foto);
            showNotif(`✅ SELAMAT DATANG, ${nama.toUpperCase()}`);
            playSound('checkin');
          } else if (res.status === 'checkout') {
            performCheckoutUI(nama);
            showNotif(`⏱️ TERIMA KASIH, ${nama.toUpperCase()}`);
            playSound('checkout');
          }
        })
        .finally(() => {
          setTimeout(() => { if (scanner) scanner.resume(); }, 3000);
        });
    }

    function addMemberToList(nama, type, fotoUrl) {
      const emptyMsg = document.getElementById('empty-msg');
      if (emptyMsg) emptyMsg.remove();
      if (rows[nama]) return;

      const item = document.createElement('div');
      item.className = "flex items-center justify-between p-4 card border border-gray-50 hover:border-purple-100 transition-all";
      item.innerHTML = `
        <div class="flex items-center gap-3">
          <img src="${fotoUrl || 'https://ui-avatars.com/api/?name=' + nama}" class="w-12 h-12 rounded-full border-2 border-purple-200">
          <div>
            <p class="font-bold text-gray-800">${nama}</p>
            <p class="text-[10px] text-gray-400 uppercase font-semibold">${type || 'MEMBER'}</p>
          </div>
        </div>
        <div class="flex items-center gap-4">
          <p id="timer-${nama}" class="text-sm font-mono font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded">0M</p>
          <button onclick="manualCheckout('${nama}', '${type}')" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
            <i data-lucide="log-out" class="w-5 h-5"></i>
          </button>
        </div>
      `;
      hasil.prepend(item);
      lucide.createIcons();

      let detik = 0;
      timers[nama] = setInterval(() => {
        detik++;
        const el = document.getElementById(`timer-${nama}`);
        if (el) {
          const h = Math.floor(detik / 3600);
          const m = Math.floor((detik % 3600) / 60);
          el.textContent = h > 0 ? `${h}H ${m}M` : `${m}M`;
        }
      }, 1000);
      rows[nama] = item;
      updateActiveCount();
    }

    function performCheckoutUI(nama) {
      if (timers[nama]) clearInterval(timers[nama]);
      if (rows[nama]) {
        rows[nama].remove();
        delete rows[nama];
        delete timers[nama];
        updateActiveCount();

        if (Object.keys(rows).length === 0) {
          hasil.innerHTML = `<p id="empty-msg" class="col-span-full text-center text-gray-400 py-20 italic">Belum ada member aktif</p>`;
        }
      }
    }

    function updateActiveCount() {
      activeCount.textContent = Object.keys(rows).length;
    }

    function manualCheckout(nama, type) {
      if (confirm(`Check-out paksa ${nama}?`)) {
        fetch("{{ route('scan.store') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ nama, type })
        }).then(() => {
          performCheckoutUI(nama);
          playSound('checkout');
        });
      }
    }

    function showNotif(text, isError = false) {
      notif.textContent = text;
      notif.className = `text-center mt-3 text-sm font-bold h-6 ${isError ? 'text-red-500' : 'text-purple-600 animate-bounce'}`;
      setTimeout(() => { notif.textContent = ""; }, 3000);
    }

    btnOn.addEventListener('click', startCamera);
    btnOff.addEventListener('click', stopCamera);
  </script>
</body>

</html>