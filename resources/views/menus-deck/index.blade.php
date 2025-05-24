<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4 d-flex justify-content-between">
            <a class="text-decoration-none text-dark">Menus Deck</a>
            <a type="btn" class="btn text-white"
                href="{{ route('menus-recommender.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                style="background-color: #203454;">
                Generate Menu
                <i class="fa-solid fa-wand-magic-sparkles ms-3" style="color: #FFD43B;"></i>
            </a>
        </div>

        <div class="p-3 rounded-3" style="border: 1px solid #ddd; white-space: nowrap">

            <div class="d-flex justify-content-end">
                <input type="month" class="form-control" style="width: 200px" id="periode" name="periode"
                    value="{{ $periode }}">
            </div>

            @foreach ($weeks as $index => $week)
                <!-- Card Title -->
                <div class="mt-3">
                    <h4>Week {{ $index + 1 }}</h4>
                </div>

                <div class="row mb-5">
                    <div class="rounded-2 d-flex align-items-center mb-5" style="
                                    overflow-x: auto;
                                    overflow-y: hidden;
                                    white-space: no-wrap;
                                    height: 300px;
                            ">
                        @foreach ($week->days as $day)
                            <div class="me-5" style="display: inline-block; vertical-align: top">
                                <!--  Card Date -->
                                <div class="mb-1" style="text-align: center; width: 200px;">
                                    {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l, d M Y') }}
                                </div>

                                <!-- Card Content -->
                                @if ($day->menus_deck)
                                    <div class="rounded-2 p-2" style="
                                                        width: 200px;
                                                        height: 200px;
                                                        border: 1px solid {{ $day->in_month ? '#a7b79c' : '#414141' }};
                                                        text-align: center;
                                                        background-color:
                                                        @if ($day->menus_deck->status == 0)
                                                            #ffd2d2
                                                        @elseif ($day->menus_deck->status == 1)
                                                            #b6f2b6
                                                        @else
                                                            {{ $day->in_month ? '#b6f2b6' : '#e7e7e7' }}
                                                        @endif
                                                        ;
                                                        position: relative;
                                                        overflow: hidden;
                                                        {{ $day->in_month ? 'cursor: pointer;' : '' }}
                                                    " @if ($day->in_month)
                                                    onclick="window.location='{{ route('menus-deck.edit', $day->menus_deck->id) }}'" @endif>
                                        <img src="{{ asset('images/food.png') }}" alt="Menu Image" style="
                                            width: 100px;
                                            height: 100px;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            margin: 10px auto;
                                            display: block;
                                        " />

                                        <h6>{{ $day->menus_deck->menu->nama_menu ?? '-' }}</h6>
                                        <small>{{ $day->menus_deck->menu->vendor->nama ?? '-' }}</small>

                                        @if (!$day->in_month)
                                            <!-- Disable Screen -->
                                            <div style="
                                                                    position: absolute;
                                                                    top: 0;
                                                                    left: 0;
                                                                    width: 200px;
                                                                    height: 200px;
                                                                    background-color: rgba(200, 200, 200, 0.5);
                                                                    z-index: 10;
                                                                "></div>
                                        @endif
                                    </div>
                                @else
                                    <!-- Add Card -->
                                    <div class="" style="display: inline-block; vertical-align: top">
                                        <div class="rounded-2" style="
                                                            width: 200px;
                                                            height: 200px;
                                                            border: 1px solid #ddd;
                                                            display: flex;
                                                            align-items: center;
                                                            justify-content: center;
                                                            position: relative;
                                                            overflow: hidden;
                                                        ">
                                            <a class="btn"
                                                href="{{ route('menus-deck.create', ['tanggal_pelaksanaan' => $day->date]) }}">
                                                <i class="fa-solid fa-square-plus fs-1" style="color: #74c0fc"></i>
                                            </a>

                                            <!-- Disable Screen -->
                                            @if (!$day->in_month)
                                                <div style="
                                                                        position: absolute;
                                                                        top: 0;
                                                                        left: 0;
                                                                        width: 200px;
                                                                        height: 200px;
                                                                        background-color: rgba(200, 200, 200, 0.5);
                                                                        z-index: 10;
                                                                    "></div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <!-- Status and Generate MenusDeck -->
                        <div class="ms-5" style="display: inline-block; vertical-align: top">
                            <div class="mb-1" style="text-align: center">Status</div>
                            <div class="rounded-2 p-2" style="
                                                width: 200px;
                                                border: 1px solid #ddd;
                                                text-align: left;
                                            ">
                                <!-- Confirmed -->
                                <div class="d-flex justify-content-start mb-2">
                                    <div style="font-size: 1.3rem; width: 30px; text-align: start">
                                        {{ $week->confirmed }}
                                    </div>
                                    <div class="ms-2 px-2 py-1 rounded" style="
                                                    width: 135px;
                                                    background-color: #b6f2b6;
                                                    border: 1px solid #59c459;
                                                    text-align: center;
                                                ">
                                        Confirmed
                                    </div>
                                </div>

                                <!-- Not Confirmed -->
                                <div class="d-flex justify-content-start mb-2">
                                    <div style="font-size: 1.3rem; width: 30px; text-align: start">
                                        {{ $week->not_confirmed }}
                                    </div>
                                    <div class="ms-2 px-2 py-1 rounded" style="
                                                    width: 135px;
                                                    background-color: #ffd2d2;
                                                    border: 1px solid #ff7a7a;
                                                    text-align: center;
                                                ">
                                        Not Confirmed
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Filter by periode
        document.getElementById('periode').addEventListener('change', function () {
            const [year, month] = this.value.split('-');
            if (year && month) {
                window.location.href = `{{ route('menus-deck.index') }}?tahun=${year}&bulan=${month}`;
            }
        });
    </script>

</x-app-layout>
