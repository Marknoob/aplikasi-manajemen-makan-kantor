<x-app-layout>
    <div class="m-3 mb-4">
        <div class="mb-4 d-flex justify-content-between">
            <div class="me-5">
                <p class="h2">Generate Menus</p>
                <p>Set Menus Deck secara otomatis dengan data acak dalam periode waktu tertentu</p>
            </div>
            <div class="d-flex align-items-center">
                <a class="btn btn-primary" onclick="generateMenus()" style="background-color: #203454;">
                    Generate Menu
                    <i class="fa-solid fa-wand-magic-sparkles ms-3" style="color: #FFD43B;"></i>
                </a>
            </div>
        </div>

        <div class="card p-3">
            <div class="mb-3 d-flex justify-content-between">
                <h4>{{ $bulanTahun }}</h4>
                <div>
                    <select id="weekSelector" class="form-select w-auto" onchange="updateWeekView()">
                        @for ($i = 1; $i <= count($weeks); $i++)
                            <option value="{{ $i }}">Week {{ $i }}</option>
                        @endfor
                        <option value="6">Month</option>
                    </select>
                </div>
            </div>

            <!-- Week View -->
            @foreach ($weeks as $index => $week)
                <div id="week-{{ $index + 1 }}" class="week-view" style="{{ $index == 0 ? '' : 'display: none' }}">
                    @include('menus-recommender.deck-cards', ['days' => $week->days])
                </div>
            @endforeach

            <!-- Month View -->
            <div id="month" class="month-view" style="display: none">
                @foreach ($weeks as $week)
                    @include('menus-recommender.deck-cards', ['days' => $week->days])
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                <form id="saveMenusForm" action="{{ route('menus-recommender.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menus_data" id="menusDataInput">
                    <button type="button" class="btn btn-success" onclick="handleSaveClick()">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </form>
            </div>

        </div>
    </div>



    <!-- Modal Notifikasi menu tidak cukup -->
    <div class="modal fade" id="notEnoughMenusModal" tabindex="-1" aria-labelledby="notEnoughMenusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notEnoughMenusLabel">Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Menu makanan yang tersedia tidak cukup untuk mengisi semua slot Menus Deck yang kosong.
                    </p>
                    <p>
                        Menu hanya akan ditambahkan sebagian saja. Atau silakan tambahkan menu baru terlebih dahulu.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Menu -->
    <div class="modal fade" id="removeConfirmModal" tabindex="-1" aria-labelledby="removeConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeConfirmModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-5 fw-bold">Apakah Anda yakin ingin menghapus menu ini ?</p>
                    <p class="fs-5 fw-bold"><span id="menuNameToRemove" class="text-danger"></span></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background-color: #ffd2d2; border: 1px solid #ff7a7a;">
                        Batal
                    </button>
                    <button type="button" class="btn" id="confirmRemoveBtn"
                        style="background-color: #b6f2b6; border: 1px solid #59c459;">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Simpan -->
    <div class="modal fade" id="saveChangesModal" tabindex="-1" aria-labelledby="saveChangesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saveChangesModalLabel">Konfirmasi Simpan Perubahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body ">
                    <p class="fs-5 fw-bold text-center">Apakah Anda yakin ingin menyimpan semua perubahan?</p>
                    <p>*Note: Penyimpanan akan dilakukan berdasarkan pilihan Week / Month.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background-color: #ffd2d2; border: 1px solid #ff7a7a;">
                        Batal
                    </button>
                    <button type="button" class="btn" onclick="saveChanges()"
                        style="background-color: #b6f2b6; border: 1px solid #59c459;">
                        Ya, Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tidak Ada Perubahan -->
    <div class="modal fade" id="noChangesModal" tabindex="-1" aria-labelledby="noChangesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tidak Ada Perubahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-5">Tidak ada menu yang dirubah.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <script>
        // Untuk merubah view saat berdasarkan pilihan week / month
        function updateWeekView() {
            const selected = parseInt(document.getElementById('weekSelector').value);
            const allViews = document.querySelectorAll('.week-view, .month-view');
            allViews.forEach(view => view.style.display = 'none');

            if (selected >= 1 && selected <= 5) {
                document.getElementById('week-' + selected).style.display = '';
            } else if (selected === 6) {
                document.getElementById('month').style.display = '';
            }
        }

        const weeksData = @json($weeks);
        const allMenus = @json($menus);
        const availableMenus = [...allMenus];
        const tempGeneratedMenu = [];

        function generateMenus() {
            const selected = parseInt(document.getElementById('weekSelector').value);

            let totalSlotToFill = 0;

            if (selected >= 1 && selected <= 5) {
                const selectedWeek = weeksData[selected - 1];
                selectedWeek.days.forEach(day => {
                    if (day.menus_deck === null && day.in_month) {
                        totalSlotToFill++;
                    }
                });
            } else if (selected === 6) {
                weeksData.forEach(week => {
                    week.days.forEach(day => {
                        if (day.menus_deck === null && day.in_month) {
                            totalSlotToFill++;
                        }
                    });
                });
            }

            // Jika jumlah menu yang tersedia kurang dari slot yang harus diisi, tampilkan modal
            if (availableMenus.length < totalSlotToFill) {
                const notEnoughModal = new bootstrap.Modal(document.getElementById('notEnoughMenusModal'));
                notEnoughModal.show();
                // return; // stop proses generate
            }

            function getRandomUniqueMenu() {
                if (availableMenus.length === 0) return null;
                const randomIndex = Math.floor(Math.random() * availableMenus.length);
                const menu = availableMenus[randomIndex];
                availableMenus.splice(randomIndex, 1);
                return menu;
            }

            if (selected >= 1 && selected <= 5) {
                const selectedWeek = weeksData[selected - 1];
                selectedWeek.days.forEach(day => {
                    const alreadyExists = tempGeneratedMenu.some(m => m.tanggal_pelaksanaan === day.date);
                    if (day.menus_deck === null && day.in_month && !alreadyExists) {
                        const randomMenu = getRandomUniqueMenu();
                        if (randomMenu) {
                            tempGeneratedMenu.push({
                                menu_id: randomMenu.id,
                                nama_menu: randomMenu.nama_menu,
                                nama_vendor: randomMenu.vendor.nama,
                                tanggal_pelaksanaan: day.date
                            });
                        }
                    }
                });
            } else if (selected === 6) {
                weeksData.forEach(week => {
                    week.days.forEach(day => {
                        const alreadyExists = tempGeneratedMenu.some(m => m.tanggal_pelaksanaan === day.date);
                        if (day.menus_deck === null && day.in_month && !alreadyExists) {
                            const randomMenu = getRandomUniqueMenu();
                            if (randomMenu) {
                                tempGeneratedMenu.push({
                                    menu_id: randomMenu.id,
                                    nama_menu: randomMenu.nama_menu,
                                    nama_vendor: randomMenu.vendor.nama,
                                    tanggal_pelaksanaan: day.date
                                });
                            }
                        }
                    });
                });
            }

            const foodImagePath = "{{ asset('images/food.png') }}";
            
            // Render card  ke tampilan
            tempGeneratedMenu.forEach(item => {
                const cardContainers = document.querySelectorAll('.day-card[data-date="' + item.tanggal_pelaksanaan + '"]');
                cardContainers.forEach(container => {
                    container.innerHTML = `
                        <div class="rounded-2 p-2" style="
                            width: 200px;
                            height: 200px;
                            border: 1px solid #1971c2;
                            text-align: center;
                            background-color: #a5d8ff;
                            position: relative;
                            overflow: hidden;">
                            <img src="${foodImagePath}" alt="Menu Image" style="
                                width: 100px;
                                height: 100px;
                                border-radius: 50%;
                                object-fit: cover;
                                margin: 10px auto;
                                display: block;
                            " />
                            <h6>${item.nama_menu}</h6>
                            <small>${item.nama_vendor}</small>
                        </div>
                    `;
                });

                // Untuk tombol Remove
                const removeBtnContainers = document.querySelectorAll('.remove-btn-placeholder[data-date="' + item.tanggal_pelaksanaan + '"]');
                removeBtnContainers.forEach(container => {
                    container.innerHTML = `
                            <a class="btn btn-sm btn-danger" onclick="removeGeneratedMenu('${item.tanggal_pelaksanaan}')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        `;
                });
            });

            console.log(tempGeneratedMenu);
        }

        // Konfirmasi remove menu
        let indexToRemove = null;

        function removeGeneratedMenu(tanggal) {
            const index = tempGeneratedMenu.findIndex(item => item.tanggal_pelaksanaan === tanggal);
            if (index !== -1) {
                const menu = tempGeneratedMenu[index];
                console.log(menu);
                const menuNameToRemove = document.getElementById('menuNameToRemove');

                if (menu && menu.nama_menu) {
                    menuNameToRemove.textContent = `${menu.nama_menu}`;
                } else {
                    menuNameToRemove.textContent = '';
                }

                const modal = new bootstrap.Modal(document.getElementById('removeConfirmModal'));
                modal.show();

                indexToRemove = index;
            }
        }

        document.getElementById('confirmRemoveBtn').addEventListener('click', function () {
            if (indexToRemove !== null) {
                removeMenu(indexToRemove);
                indexToRemove = null;
                const modalElement = document.getElementById('removeConfirmModal');
                bootstrap.Modal.getInstance(modalElement).hide();
            }
        });

        function removeMenu(index) {
            if (index !== -1 && index < tempGeneratedMenu.length) {
                // Hapus menu dari tempGeneratedMenu
                const removedItem = tempGeneratedMenu.splice(index, 1)[0];
                const tanggal = removedItem.tanggal_pelaksanaan;
                const menuId = removedItem.menu_id;

                // Tambahkan menu yang dihapus kembali ke availableMenus
                const removedMenu = allMenus.find(m => m.id === menuId);
                const alreadyExists = availableMenus.some(m => m.id === removedMenu.id);
                if (!alreadyExists) {
                    availableMenus.push(removedMenu);
                }

                // Ambil status in_month dari weeksData
                let inMonth = false;
                for (const week of weeksData) {
                    const foundDay = week.days.find(d => d.date === tanggal);
                    if (foundDay) {
                        inMonth = foundDay.in_month;
                        break;
                    }
                }

                // Kembalikan tampilan card menjadi Add Card
                const containers = document.querySelectorAll('.day-card[data-date="' + tanggal + '"]');
                containers.forEach(container => {
                    container.outerHTML = getAddCardHTML(tanggal, inMonth);
                });

                // Hapus tombol remove
                const removeBtnContainers = document.querySelectorAll('.remove-btn-placeholder[data-date="' + tanggal + '"]');
                removeBtnContainers.forEach(container => container.innerHTML = '');
            }
        }


        function getAddCardHTML(tanggal, inMonth) {
            return `
                    <div class="rounded-2 day-card" data-date="${tanggal}" style="
                        width: 200px;
                        height: 200px;
                        border: 1px solid #ddd;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        position: relative;
                        overflow: hidden;">
                        <a class="btn">
                            <i class="fa-solid fa-square-plus fs-1" style="color: #74c0fc"></i>
                        </a>
                        ${!inMonth ? `
                            <div style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 200px;
                                height: 200px;
                                background-color: rgba(200, 200, 200, 0.5);
                                z-index: 10;">
                            </div>` : ''}
                    </div>
                `;
        }

        function handleSaveClick() {
            if (Array.isArray(tempGeneratedMenu) && tempGeneratedMenu.length > 0) {
                const modal = new bootstrap.Modal(document.getElementById('saveChangesModal'));
                modal.show();
            } else {
                const noChanges = new bootstrap.Modal(document.getElementById('noChangesModal'));
                noChanges.show();
            }
        }

        function saveChanges() {
            if (tempGeneratedMenu.length > 0) {
                // Save data
                const saveForm = document.getElementById('saveMenusForm');
                const menusDataInput = document.getElementById('menusDataInput');

                // Pastikan hanya data sesuai week (jika week dipilih) yang dikirim
                const selected = parseInt(document.getElementById('weekSelector').value);
                let dataToSend = [];

                if (selected >= 1 && selected <= 5) {
                    const selectedWeek = weeksData[selected - 1];
                    const datesInWeek = selectedWeek.days.map(day => day.date);
                    dataToSend = tempGeneratedMenu.filter(item => datesInWeek.includes(item.tanggal_pelaksanaan));
                } else if (selected === 6) {
                    dataToSend = [...tempGeneratedMenu];
                }

                // Set ke input hidden
                menusDataInput.value = JSON.stringify(dataToSend);

                // Submit
                saveForm.submit();
            }
        }
    </script>
</x-app-layout>
