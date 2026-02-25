@if (config('sweetalert.alwaysLoadJS') === true || Session::has('alert.config') || Session::has('alert.delete'))
    @if (config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif

    @if (config('sweetalert.theme') != 'default')
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-{{ config('sweetalert.theme') }}" rel="stylesheet">
    @endif

    @if (config('sweetalert.neverLoadJS') === false)
        <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @endif

    @if (Session::has('alert.delete') || Session::has('alert.config'))
        @php
            // Ambil data dari session dan hapus (pull)
            $deleteData = session()->pull('alert.delete');
            $configData = session()->pull('alert.config');

            // Encode data ke JSON dengan flag keamanan maksimal
            // JSON_HEX_TAG, JSON_HEX_APOS, JSON_HEX_QUOT, JSON_HEX_AMP mengubah karakter berbahaya menjadi \uXXXX
            $deleteJson = $deleteData ? json_encode($deleteData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) : null;
            $configJson = $configData ? json_encode($configData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) : null;
        @endphp

        {{-- Simpan data dalam elemen tersembunyi --}}
        @if($deleteJson)
            <div id="swal-delete-data" data-delete="{{ $deleteJson }}" style="display: none;"></div>
        @endif
        @if($configJson)
            <div id="swal-config-data" data-config="{{ $configJson }}" style="display: none;"></div>
        @endif

        <script>
            (function() {
                // Fungsi untuk membaca data dari elemen tersembunyi
                function getSwalData(elementId, dataAttr) {
                    const el = document.getElementById(elementId);
                    if (!el) return null;
                    try {
                        return JSON.parse(el.dataset[dataAttr]);
                    } catch (e) {
                        console.error('Gagal parse data SweetAlert:', e);
                        return null;
                    }
                }

                const _swalDelete = getSwalData('swal-delete-data', 'delete');
                const _swalConfig = getSwalData('swal-config-data', 'config');

                // Handle konfirmasi hapus
                if (_swalDelete) {
                    document.addEventListener('click', function(event) {
                        const target = event.target;
                        const confirmDeleteElement = target.closest('[data-confirm-delete]');

                        if (confirmDeleteElement) {
                            event.preventDefault();
                            Swal.fire(_swalDelete).then(function(result) {
                                if (result.isConfirmed) {
                                    const form = document.createElement('form');
                                    form.action = confirmDeleteElement.href;
                                    form.method = 'POST';

                                    const tokenInput = document.createElement('input');
                                    tokenInput.type = 'hidden';
                                    tokenInput.name = '_token';
                                    tokenInput.value = '{{ csrf_token() }}';
                                    form.appendChild(tokenInput);

                                    const methodInput = document.createElement('input');
                                    methodInput.type = 'hidden';
                                    methodInput.name = '_method';
                                    methodInput.value = 'DELETE';
                                    form.appendChild(methodInput);

                                    document.body.appendChild(form);
                                    form.submit();
                                }
                            });
                        }
                    });
                }

                // Tampilkan alert konfigurasi
                if (_swalConfig) {
                    Swal.fire(_swalConfig);
                }
            })();
        </script>
    @endif

@endif
