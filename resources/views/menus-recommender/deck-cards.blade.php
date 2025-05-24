{{-- This page card used in index in menus-recommender.index --}}
<div class="row mb-4">
    <div class="rounded-2 d-flex align-items-center" style="
        overflow-x: auto;
        overflow-y: hidden;
        white-space: no-wrap;
        height: 300px;
    ">
        @foreach ($days as $day)
            <div class="me-5" style="display: inline-block; vertical-align: top">
                <!--  Card Date -->
                <div class="mb-1" style="text-align: center; width: 200px;">
                    {{ \Carbon\Carbon::parse($day->date)->translatedFormat('l, d M Y') }}
                </div>

                <!-- Card Content -->
                @if ($day->menus_deck)
                    <!-- Card -->
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
                        overflow: hidden;">
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
                            <div style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 200px;
                                height: 200px;
                                background-color: rgba(200, 200, 200, 0.5);
                                z-index: 10;">
                            </div>
                        @endif
                    </div>

                    <!-- Remove Button -->
                    <div class="text-center mt-2" style="text-align: center; height: 30px;">
                        &nbsp;
                    </div>
                @else
                    <!-- Add Card -->
                    <div class="rounded-2 day-card" data-date="{{ $day->date }}" style="
                            width: 200px;
                            height: 200px;
                            border: 1px solid #ddd;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            position: relative;
                            overflow: hidden;">
                        <a class="btn" style="pointer-events: none; cursor: default;">
                            <i class="fa-solid fa-square-plus fs-1" style="color: #74c0fc"></i>
                        </a>
                        @if (!$day->in_month)
                            <div style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 200px;
                                height: 200px;
                                background-color: rgba(200, 200, 200, 0.5);
                                z-index: 10;">
                            </div>
                        @endif
                    </div>

                    <!-- Remove Button -->
                    <div class="remove-btn-placeholder text-center mt-2" data-date="{{ $day->date }}" style="text-align: center; height: 30px;">
                        {{-- btn remove akan diisi oleh js pada menus-recommender.index --}}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
